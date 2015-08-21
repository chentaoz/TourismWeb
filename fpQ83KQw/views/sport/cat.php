<?php $this->load->view('head_other_v1', array('currentTab' => 2)); ?>
<style type="text/css">
    #article_content img{max-width: 100%;}

    .wp .article-box {
        position:relative;
        display: block;
        overflow: hidden;
        color: white;
        font-size: 1.2em;
        padding: 0!important;
    }

    .wp .article-box:nth-child(3n+3):after {
        clear: both;
    }

    .wp .article-box img:hover {
        filter: grayscale(1) blur(4px);
        -webkit-filter: grayscale(1) blur(4px);
        -moz-filter: grayscale(1) blur(4px);
        -o-filter: grayscale(1) blur(4px);
        -ms-filter: grayscale(1) blur(4px);
    }
    @media only screen and (min-width : 1224px) {
        .article-box img {
            height: 200px!important;
            width: 100%!important;
        }
    }



    .wp .article-box img {
        position: relative;
        height: inherit;
        margin: 0!important;
        padding: 0!important;
        overflow: hidden;
    }
    .wp .article-box .desc{
        position: absolute;
        bottom: 0;
        width: 100%;
        box-sizing: border-box;
        padding: 2.5em 0.71429em 0.57143em;
        text-transform: uppercase;
        background: -webkit-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,0.65));
        background: linear-gradient(to bottom, rgba(0,0,0,0),rgba(0,0,0,0.65));
        -webkit-transition: background 250ms ease-out;
        transition: background 250ms ease-out;
        -webkit-backface-visibility: hidden;
        -webkit-transform: translateZ(0) scale(1, 1);
    }

    .wp .article-box a {
        color: #bbb;
        text-decoration: none;
    }

    .wp .article-box a:hover {
        color : white;
    }

    #bar-load-more-row {
        text-align: center;
    }

    #bar-load-more {
        text-align: center;
        padding: 6px 0;
        font-size: 1.4em;
        font-weight: 200;
        background-color: #f0f0f0;
        color: #555;
        margin: 10px auto;
        float: none!important;

        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        border-radius: 6px; /* future proofing */
        -khtml-border-radius: 6px; /* for old Konqueror browsers */
    }

    #bar-load-more:hover {
        background-color: #548F1E;
        color: white;
    }
</style>
<!-- main-->
<div class="wp">
    <div class="row" style="margin: 30px 0!important;" id="article-container">
        <?php
        if($articles) {

            foreach ($articles as $article) {
                $_image_url  = base_url('upload/news/'.$article['img']);
                $_image_path = FCPATH . 'upload/news/' . $article['img'];

                if(is_file($_image_path)) {
                    list($_width, $_height) = getimagesize($_image_path);
                    ?>

                    <div class="col-md-4 col-sm-6 pull-left article-box">
                        <a href="<?php echo base_url('sport/news_show/id/' . $article['id']) ?>">
                            <img src="<?php echo $_image_url ?>" alt="<?=$article['title'] ?>" class="img-responsive" />
                            <div class="desc">
                                <?=$article['title'] ?>
                            </div>
                        </a>
                    </div>

                <?php
                };
            };
        };?>
    </div>
    <div class="row" id="bar-load-more-row">
        <div class="col-md-8" id="bar-load-more">加载更多</div>
    </div>

</div>
<!-- main-->
<?php $this->load->view('foot_v1'); ?>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#bar-load-more').click(function() {
            var _offset = $('.article-box').length;
            var _num = 6;

            $.get("<?php echo base_url('sport/cate_pull/'.$spid) ?>"+'/'+_offset+'/'+_num, function(_data){
                $('#article-container').append(_data);
            })
        });
    });
</script>
</body>
</html>