<?= $this->extend('base') ?>

<?= $this->section('content') ?>


<?php if (session()->getFlashdata('alert')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?= session()->getFlashdata('alert') ?></strong> <a href="<?php echo base_url('/logout'); ?>">Logout</a>
        <button type="button" class="btn btn-secondary" class="btn-close"
                data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row g-3">

    <div class="insert-field card shadow p-3 mb-5 bg-body rounded p-3" id="insert_field">
        <form action="<?php echo base_url('/upload') ?>" method="POST">
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
            <h4>New Post</h4>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Type the content." id="new_post"
                          name="body" style="height: 100px"></textarea>
                <label for="new_post">Contents</label>
                <button type="submit" class="btn btn-secondary mt-2">Send <i class="bi bi-send"></i></button>
            </div>
        </form>
    </div>

    <h3>Latest Posts</h3>
    <?php foreach ($posts as $post) : ?>
        <div class="card shadow p-3 mb-5 bg-body rounded col-12 p-3">
            <div class="card-body">
                <blockquote class="blockquote mb-0" id="blockquote_<?= $post['post_id'] ?>">
                    <p id="body_<?= $post['post_id'] ?>"><?= $post['body']; ?></p>
                    <footer class="blockquote-footer mt-2">
                        <i>
                            <?php if ($post['author'] == session()->get('name')) {
                                echo 'Me';
                            } else {
                                echo $post['author'];
                            }?> at <?php echo date_format(date_create($post['created_at']),"l, d F Y"); ?>
                        </i>
                    </footer>
                </blockquote>
            </div>
            <?php if ($post['author'] == session()->get('name')) : ?>
                <div class="card-footer">
                    <div class="float-end">
                        <button type="button" class="btn btn-warning edit-btn" id="<?= 'edit_button_' . $post['post_id'] ?>" 
                                onclick="editPost(<?= $post['post_id'] ?>)">Edit <i class="bi bi-pencil"></i></button>
                        <button type="button" class="btn btn-danger delete-btn" id="<?= 'del_button_' . $post['post_id'] ?>"
                                onclick="delPost(<?= $post['post_id'] ?>)">Delete <i class="bi bi-trash"></i></button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<hr id="horizontal">
<form action="" method="POST" id="del_form">
    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
</form>
<h3>Search Post</h3>
<div class="search-field" id="search_field">
    <div class="input-group mb-3">
        <input type="text" class="custom-input" id="q_term" aria-label="Search Term" aria-describedby="q_term">
        <button type="button" class="btn btn-secondary" id="search_btn" onclick="searchPost()"><i class="bi bi-search"></i></button>
    </div>
    <div class="row g-2 mt-3" id="search_result"></div>
</div>
<?= $this->endSection() ?>