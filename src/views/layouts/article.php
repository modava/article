<?php

\modava\article\assets\ArticleAsset::register($this);
\modava\article\assets\ArticleCustomAsset::register($this);
?>
<?php $this->beginContent('@backend/views/layouts/main.php'); ?>
<?php echo $content ?>
<?php $this->endContent(); ?>