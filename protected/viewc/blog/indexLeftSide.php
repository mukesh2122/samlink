<div id="blog_left_column">
<?php
    echo $this->renderBlock('blog/mostRead', array('mostReadList' => $mostReadList));
    echo $this->renderBlock('blog/mostPopular');
?>
</div>
