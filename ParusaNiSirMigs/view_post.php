<?php

session_start();

include "config.php";


/* check login */
if(!isset($_SESSION['user_id'])){

    header("Location: login.php");

    exit();

}

$user_id = $_SESSION['user_id'];

/* get post id */
if(!isset($_GET['id'])){

    header("Location: community.php");

    exit();

}


$post_id = $_GET['id'];


/* get post */
$query = mysqli_query(

    $conn,

    "
    SELECT

        posts.id,
        posts.title,
        posts.body,
        posts.created_at,
        users.username

    FROM posts

    INNER JOIN users
        ON posts.user_id = users.id

    WHERE posts.id='$post_id'
    "

);


$post = mysqli_fetch_assoc($query);

if(!$post){

    echo "Post not found.";

    exit();

}


/* count likes */
$like_query = mysqli_query(

    $conn,

    "
    SELECT COUNT(*) AS total_likes

    FROM likes

    WHERE post_id='$post_id'
    "

);


$like_data = mysqli_fetch_assoc(
    $like_query
);


$like_count =
    $like_data['total_likes'];


/* check if user liked */
$user_like_query = mysqli_query(

    $conn,

    "
    SELECT id

    FROM likes

    WHERE post_id='$post_id'

    AND user_id='$user_id'
    "

);


$user_liked =
    mysqli_num_rows(
        $user_like_query
    ) > 0;


/* count comments */
$comment_count_query = mysqli_query(

    $conn,

    "
    SELECT COUNT(*) AS total_comments

    FROM comments

    WHERE post_id='$post_id'
    "

);


$comment_count =
    mysqli_fetch_assoc(
        $comment_count_query
    );


/* get comments */
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

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars($post['title']); ?>
        - BLOG APP
    </title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>

<body>


<?php include "navbar.php"; ?>


<div class="container">


    <div class="community-post">

        <h3>

            <?= htmlspecialchars(
                $post['title']
            ); ?>

        </h3>

        <p>

            <?= nl2br(
                htmlspecialchars(
                    $post['body']
                )
            ); ?>

        </p>

        <small>

            Posted by:

            <b>

                <?= htmlspecialchars(
                    $post['username']
                ); ?>

            </b>


            &nbsp; | &nbsp;


            <?= htmlspecialchars(
                $post['created_at']
            ); ?>

        </small>

        <div class="post-buttons">


            <form
                action="like_post.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="post_id"
                    value="<?= $post['id']; ?>"
                >


                <?php if($user_liked): ?>

                    <button
                        type="submit"
                        class="like-button liked"
                    >
                        ♥ Unlike <?= $like_count; ?>
                    </button>

                <?php else: ?>

                    <button
                        type="submit"
                        class="like-button"
                    >
                        ♡ Like <?= $like_count; ?>
                    </button>

                <?php endif; ?>


            </form>

            <button
                type="button"
                class="share-button"

                onclick="sharePost(
                    '<?= htmlspecialchars(
                        $post['title'],
                        ENT_QUOTES
                    ); ?>',

                    '<?= $post['id']; ?>'
                )"
            >
                ↗ Share
            </button>


        </div>

        <div class="comment-count">

            Comments
            (<?= $comment_count['total_comments']; ?>)

        </div>

        <?php while(
            $comment = mysqli_fetch_assoc($comments)
        ): ?>


            <div class="comment">


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


        <?php endwhile; ?>

        <form
            action="add_comment.php"
            method="POST"
            class="comment-form"
        >


            <input
                type="hidden"
                name="post_id"
                value="<?= $post['id']; ?>"
            >


            <input
                type="text"
                name="body"
                placeholder="Write a comment..."
                required
            >


            <button
                type="submit"
            >
                Add Comment
            </button>


        </form>


    </div>


</div>


<script>

function sharePost(title, postId) {


    const postUrl =
        window.location.origin +
        '/blog_app/view_post.php?id=' +
        postId;


    if(navigator.share){

        navigator.share({

            title: title,

            text: 'Check out this post: ' + title,

            url: postUrl

        });

    }

    else{

        navigator.clipboard.writeText(postUrl);

        alert('Post link copied!');

    }

}

</script>


</body>

</html>