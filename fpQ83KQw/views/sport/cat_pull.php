
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
};

?>
