<?php

session_start();

// Show real MySQL errors instead of mysqli_query() silently returning false.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include "config.php";


if (!isset($_SESSION['user_id'])) {
    header("Location:login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Community Feed - BLOG APP</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

    <div class="page-header">

        <h2>COMMUNITY FEED</h2>

    </div>

    <!-- composer -->
    <a href="add_post.php" class="composer">

        <div class="avatar">
            <?= htmlspecialchars(
                strtoupper(substr($_SESSION['username'] ?? '?', 0, 1))
            ); ?>
        </div>

        <span class="composer-input">
            What's on your mind, <?= htmlspecialchars($_SESSION['username'] ?? ''); ?>?
        </span>

    </a>

    <?php

    /* get all post */
    $query = mysqli_query(

        $conn,

        "
        SELECT
            posts.id,
            posts.user_id,
            posts.title,
            posts.body,
            posts.created_at,
            posts.updated_at,
            users.username

        FROM posts

        INNER JOIN users

            ON posts.user_id = users.id

        ORDER BY posts.created_at DESC
        "
    );

    while ($post = mysqli_fetch_assoc($query)):

    ?>

        <div
            class="community-post"
            id="post-<?= $post['id']; ?>"
        >

            <!-- post meta: avatar + name + time -->
            <div class="post-meta">

                <div class="avatar">
                    <?= htmlspecialchars(
                        strtoupper(substr($post['username'], 0, 1))
                    ); ?>
                </div>

                <div class="post-meta-text">

                    <b class="post-author"><?= htmlspecialchars($post['username']); ?></b>

                    <small class="post-info">
                        <?= htmlspecialchars($post['created_at']); ?>
                    </small>

                </div>

            </div>

            <!-- post title -->
            <h3>
                <?= htmlspecialchars(
                    $post['title']
                ); ?>
            </h3>


            <!-- post content  -->
            <p>

                <?= nl2br(
                    htmlspecialchars(
                        $post['body']
                    )
                ); ?>
            </p>

            <?php

            $post_id = $post['id'];


            /* count comments */
            $comment_count_query = mysqli_query(

                $conn,

                "
                SELECT COUNT(*) AS total_comments

                FROM comments

                WHERE post_id='$post_id'
                "
            );

            $comment_count = $comment_count_query
                ? mysqli_fetch_assoc($comment_count_query)
                : ['total_comments' => 0];

            $total_comments =
                $comment_count['total_comments'];


            /* count likes */
            $like_count_query = mysqli_query(

                $conn,

                "
                SELECT COUNT(*) AS total_likes

                FROM likes

                WHERE post_id='$post_id'
                "
            );

            $like_count = $like_count_query
                ? mysqli_fetch_assoc($like_count_query)
                : ['total_likes' => 0];

            $total_likes =
                $like_count['total_likes'];


            /* check current likes */
            $like_check = mysqli_query(

                $conn,

                "
                SELECT id

                FROM likes

                WHERE post_id='$post_id'

                AND user_id='{$_SESSION['user_id']}'
                "
            );

            $is_liked =
                $like_check && mysqli_num_rows($like_check) > 0;

            ?>

            <!-- like / comment counts -->
            <?php if ($total_likes > 0 || $total_comments > 0): ?>

                <div class="post-stats">

                    <?php if ($total_likes > 0): ?>
                        <span class="stat-likes">
                            <span class="like-dot">👍</span>
                            <?= $total_likes; ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($total_comments > 0): ?>
                        <span class="stat-comments">
                            <?= $total_comments; ?>
                            <?= ($total_comments == 1) ? ' comment' : ' comments'; ?>
                        </span>
                    <?php endif; ?>

                </div>

            <?php endif; ?>


            <!-- like/comment/share -->
            <div class="like-share-section">

                <!-- like -->
                <div class="like-section">

                    <form
                        action="like_post.php"
                        method="POST"
                    >

                        <input
                            type="hidden"
                            name="post_id"
                            value="<?= $post['id']; ?>"
                        >

                        <button
                            type="submit"
                            class="like-button
                            <?= $is_liked ? 'liked' : ''; ?>"
                        >

                            <svg viewBox="0 0 24 24" width="18" height="18" fill="<?= $is_liked ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2" stroke-linejoin="round">
                                <path d="M7 22V11l6-9 1.5 1.5L13 10h7a2 2 0 0 1 2 2.4l-1.6 7A2 2 0 0 1 18.4 21H10a3 3 0 0 1-3-3z"></path>
                            </svg>

                            <?= $is_liked ? 'Liked' : 'Like'; ?>

                        </button>

                    </form>

                </div>

                <!-- comment (focuses comment box below) -->
                <div class="comment-section">

                    <button
                        type="button"
                        class="comment-button"
                        onclick="document.getElementById('comment-input-<?= $post['id']; ?>').focus()"
                    >

                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>

                        Comment

                    </button>

                </div>


                <!-- share -->
                <div class="share-section">

                    <button
                        type="button"
                        class="share-button"
                        onclick="sharePost(
                            '<?= htmlspecialchars(
                                $post['title'],
                                ENT_QUOTES
                            ); ?>',
                            '<?= htmlspecialchars(
                                'http://' .
                                $_SERVER['HTTP_HOST'] .
                                dirname($_SERVER['PHP_SELF']) .
                                '/community.php#post-' .
                                $post['id'],
                                ENT_QUOTES
                            ); ?>'
                        )"
                    >

                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" stroke-linecap="round">
                            <path d="M4 12v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7"></path>
                            <path d="M16 6l-4-4-4 4"></path>
                            <path d="M12 2v13"></path>
                        </svg>

                        Share

                    </button>

                </div>

            </div>


            <!-- comments -->
            <?php

            $comments = mysqli_query(

                $conn,

                "
                SELECT

                    comments.body,
                    comments.created_at,
                    users.username

                FROM comments

                INNER JOIN users

                    ON comments.user_id = users.id

                WHERE comments.post_id='$post_id'

                ORDER BY comments.created_at ASC
                "
            );

            ?>

            <?php if ($comments && mysqli_num_rows($comments) > 0): ?>

            <div class="comment-list">

            <?php while (
                $comment =
                mysqli_fetch_assoc($comments)
            ): ?>

                <div class="comment">

                    <div class="avatar avatar-xs">
                        <?= htmlspecialchars(
                            strtoupper(substr($comment['username'], 0, 1))
                        ); ?>
                    </div>

                    <div class="comment-bubble">

                        <b>

                            <?= htmlspecialchars(
                                $comment['username']
                            ); ?>

                        </b>

                        <p>

                            <?= nl2br(
                                htmlspecialchars(
                                    $comment['body']
                                )
                            ); ?>

                        </p>

                        <small>

                            <?= htmlspecialchars(
                                $comment['created_at']
                            ); ?>

                        </small>

                    </div>

                </div>


            <?php endwhile; ?>

            </div>

            <?php endif; ?>


            <!-- add comment -->
            <form
                action="add_comment.php"
                method="POST"
                class="comment-form"
            >

                <div class="avatar avatar-xs">
                    <?= htmlspecialchars(
                        strtoupper(substr($_SESSION['username'] ?? '?', 0, 1))
                    ); ?>
                </div>

                <input
                    type="hidden"
                    name="post_id"
                    value="<?= $post['id']; ?>"
                >

                <input
                    type="text"
                    name="body"
                    id="comment-input-<?= $post['id']; ?>"
                    placeholder="Write a comment..."
                    required
                >

                <button type="submit">

                    Post

                </button>

            </form>

        </div>


    <?php endwhile; ?>

</div>


<script>

function sharePost(title, url) {

    if (navigator.share) {

        navigator.share({

            title: title,

            url: url

        }).catch(function () {

            console.log("Share cancelled.");

        });

    }

    else {

        navigator.clipboard.writeText(url)

        .then(function () {

            alert("Post link copied!");

        })

        .catch(function () {

            alert("Unable to copy the post link.");

        });

    }

}

</script>


</body>

</html>