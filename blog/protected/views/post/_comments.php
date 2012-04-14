<?php foreach ($comments as $comment): ?>
    <div class="comment <?php echo ($depth % 2) ? 'bg-comment-e' : 'bg-comment-o'; ?>" id="c<?php echo $comment->id; ?>">

        <?php
        echo CHtml::link("#{$comment->id}", $comment->getUrl($post), array(
            'class' => 'cid',
            'title' => 'Permalink to this comment',
        ));
        ?>

        <div class="author">
            <?php echo $comment->authorLink; ?> says:
        </div>

        <div class="time">
            <?php echo date('j F, Y \a\t h:i a', $comment->create_time); ?>
        </div>

        <div class="content">
            <?php echo nl2br(CHtml::encode($comment->content)); ?>
        </div>
        <?php
        if ($depth <= 5) {
            echo CHtml::link('Reply', 'javascript:void(0);', array(
                'class' => 'reply-link',
                'data-commentid' => $comment->id));
        }
        $this->renderPartial('_comments', array(
            'post' => $post,
            'comments' => $comment->comments,
            'depth' => $depth + 1,
        ));
        ?>

    </div><!-- comment -->
<?php endforeach; ?>