<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('AJAX_REQUEST', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
// if(!AJAX_REQUEST) {die();}

/**
 * Class Ws
 */
class Ws extends CI_Controller {
    public function __construct () {
        parent::__construct();

        $this->load->model('sport_model', 'sport');
    }

    public function endpoint() {
        if(!AJAX_REQUEST) {
            show_404();
            return;
        }

        $_params = func_get_args();

        if(0 == count($_params)) {
            $_msg = new BasicErrorMessage();
            $_msg->message = "not action";

            echo json_encode($_msg);
        } else {
            $_func = $_params[0];

            switch($_func) {
                case 'map_pull_data':
                    $ret = array();

                    $_arr_filter_sports = $this->input->post('filter_sports');
                    $_arr_filter_poi    = $this->input->post('filter_poi');

                    if(!$_arr_filter_poi && !$_arr_filter_sports) {
                        $_dests = $this->sport->filterDestinations([]);
                        $ret = array_merge($ret, $_dests);
                    } elseif ($_arr_filter_sports && in_array('destination', $_arr_filter_poi)) {
                        $_dests = $this->sport->filterDestinations($_arr_filter_sports);
                        $ret = array_merge($ret, $_dests);
                    }

                    if(!$_arr_filter_poi && !$_arr_filter_sports) {
                        $ret = array_merge($ret, $this->sport->filterNationalParks());
                    } elseif ($_arr_filter_sports && !in_array('national_park', $_arr_filter_poi)) {
                        // do nothing
                    } elseif (in_array('national_park', $_arr_filter_poi)) {
                        $ret = array_merge($ret, $this->sport->filterNationalParks());
                    }

                    header('content-type: application/json');
                    echo @json_encode($ret);

                    break;

                case 'search_dest_by_keywords':
                    $_keyword = $this->input->get('keyword');
                    $_keyword = trim($_keyword);


                    if($_keyword) {
                        $_dests = $this->db->select('p.pid, p.name, p.name_en, p.score, p.description, p.del, p.deep, p.hot, p.longitude, p.latitude'
                            . ', ps.weight, ps.sport_index, ps.sport_id')
                            ->from('place_sport ps')
                            ->join('place as p', 'p.pid = ps.place_id', 'left')
                            ->join('sport as sp', 'sp.spid = ps.sport_id', 'left')
                            ->where('p.longitude is not null', null, false)
                            ->like('p.name', $_keyword)
                            ->or_like('p.name_en', $_keyword)
                            ->or_like('p.description', $_keyword)
                            ->where('p.sta', 0)
                            ->where('sp.sta', 0)
                            ->where('sp.del', 0)
                            ->where('ps.sta', 0)
                            ->distinct()
                            ->get()->result();


                        $_nps = $this->db->select("'park' as sport_id, p.pid, p.name, p.name_en, p.score, p.description, p.del, p.deep, p.hot, p.longitude, p.latitude", false)
                            ->from('place as p')
                            ->where('p.longitude is not null', null, false)
                            ->where("(p.name like '%{$_keyword}%' or p.name_en like '%{$_keyword}%' or p.description like '%{$_keyword}%') and p.name like '%国家公园%'", null, false)
                            // ->like('p.name', $_keyword)
                            // ->or_like('p.name_en', $_keyword)
                            // ->or_like('p.description', $_keyword)
                            ->where('p.sta', 0)
                            ->where('p.del', 0)
                            // ->like('p.name', '国家公园')
                            ->distinct()
                            ->get()->result();


                        /*if($_arr_filter_sports = $this->input->post('filter_sports')) {
                            $this->db->where_in('ps.sport_id', $_arr_filter_sports);
                        }*/


                        header('content-type: application/json');
                        echo @json_encode(array_merge($_dests, $_nps));

                    } else {
                        $_msg = new BasicErrorMessage();
                        $_msg->message = "keyword is null";

                        echo json_encode($_msg);
                        return;
                    }
                    break;

                case 'get_national_parks':
                    header('content-type: application/json');
                    echo json_encode($this->sport->filterNationalParks());

                    break;

                case 'get_dests':
                    // echo json_encode($this->input->post());return;
                    $_arr_filter_sports = $this->input->post('filter_sports');

                    $_dests = array();
                    if(is_array($_arr_filter_sports)) {
                        if(in_array('all', $_arr_filter_sports)) {
                            $_dests = $this->sport->filterDestinations([]);
                        } elseif ($_arr_filter_sports && 0 < count($_arr_filter_sports) && !in_array('all', $_arr_filter_sports)) {
                            $_dests = $this->sport->filterDestinations($_arr_filter_sports);
                        }
                    }

                    header('content-type: application/json');
                    echo json_encode($_dests); return;
                    break;

                default:

                    break;
            }
        }
    }

}

class BasicSuccessMessage {
    public function __construct () {}

    var $status = "success";
    var $code   = 200;
    var $data   = array();
}

class BasicErrorMessage {
    public function __construct () {}

    var $status = "error";
    var $code   = "400";
    var $message   = null;
}