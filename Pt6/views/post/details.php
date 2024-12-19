<h1><?php echo $post['title']; ?></h1>
<p><?php echo $post['content']; ?></p>
<h3>Comentarios:</h3>
<?php foreach ($comments as $comment): ?>
    <p><?php echo $comment['content']; ?></p>
<?php endforeach; ?>
<form method="post" action="add_comment.php">
    <textarea name="content"></textarea>
    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
    <input type="submit" value="Comentar">
</form>