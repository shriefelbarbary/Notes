<?php
$connection=require_once 'Connection.php';
$notes=$connection->getNotes();

$currentnote = ['id'=>'', 'title'=>'', 'description'=>''];
if (isset($_GET['id'])){
    $currentnote=$connection->getNoteById($_GET['id']) ?? ['id'=>'', 'title' => '', 'description' => ''];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<center>
<div>
    <form class="new-note" action="save.php" method="post">
        <input type="hidden" name="id" value="<?php echo $currentnote['id']?>">
       <input  type="text" name="title" placeholder="Note title" autocomplete="off" value="<?php echo htmlspecialchars($currentnote['title'])?>">
        <br><br><br>
        <textarea name="description"  cols="32" rows="5"
                  placeholder="Note Description"><?php echo (htmlspecialchars($currentnote['description'])) ?></textarea>
        <button>
            <?php if (!empty($currentnote['id'])): ?>
                Update Note
            <?php else: ?>
                New Note
            <?php endif; ?>

        </button>
    </form>
    <div class="notes">
        <?php foreach ($notes as $note): ?>
            <div class="note">
                <div class="title">
                    <a href="?id=<?php echo htmlspecialchars($note['id'])?>"><?php echo htmlspecialchars($note['title']); ?></a>
                </div>
                <div class="description">
                    <?php echo nl2br(htmlspecialchars($note['description'])); ?>
                </div>
                <small><?php echo htmlspecialchars($note['created_at']); ?></small>
                <form action="delete.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $note['id']?>">
                    <button class="close">X</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</center>
</body>
</html>