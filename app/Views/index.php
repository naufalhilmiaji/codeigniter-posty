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
    <h3>Latest Posts</h3>

    <div class="insert-field card p-3" id="insert_field">
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

    <?php foreach ($posts as $post) : ?>
        <div class="card col-12 p-3">
            <div class="card-body">
                <blockquote class="blockquote mb-0" id="blockquote_<?= $post['post_id'] ?>">
                    <p id="body_<?= $post['post_id'] ?>"><?= $post['body']; ?></p>
                    <footer class="blockquote-footer mt-2">
                        <i><?= $post['author']; ?> at <?php echo date_format(date_create($post['created_at']),"l, d F Y"); ?></i>
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
<script>
    function editPost(id) {
        const textareaField = `
            <form action="<?php echo base_url('/update/') . '/' ?>` + id + `" id="edit_form_`+ id +`" method="post">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Write your content here."id="body_edit_`+ id +`"
                                name="body_edit" style="height: 200px;"></textarea>
                    <label for="body_edit_`+ id +`">Edit Content</label>
                </div>

                <button type="submit" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary" id="cancel_edit_`+ id +`"
                        onclick="cancelEdit(`+ id +`)">Cancel</button>
            </form>
        `;
        const body = document.querySelector('#body_' + id);
        body.outerHTML = textareaField;
        
        if (document.querySelector('#edit_field')) {
            document.querySelector('#edit_field').remove();
        }
        const url = "<?php echo base_url('/edit/') . '/' ?>" + id;

        fetch(url, {
                method: 'GET',
            })
            .then((response) => response.json())
            .then((data) => {
                const bodyEdit = document.querySelector('#body_edit_'+id);
                bodyEdit.value = data.body.body.replaceAll('<br />', '');
            });
    }

    function cancelEdit(id) {
        const textValue = document.querySelector('#body_edit_' + id).value;
        const post = document.querySelector('#edit_form_' + id);

        const postBody = `
            <blockquote class="blockquote mb-0" id="blockquote_`+ id +`">
                <p id="body_`+ id +`">`+ textValue +`</p>
            </blockquote>
        `;

        post.outerHTML = postBody;
    }

    function delPost(id) {
        const url = "<?php echo base_url('/delete/') . '/' ?>" + id;
        const con = confirm("Do you want to delete this?");

        if (con == true) {
            document.querySelector('#del_form').action = url;
            document.querySelector('#del_form').submit();
        }
    }

    function searchPost() {
        const term = document.querySelector('#q_term').value;
        const q_div = document.querySelector('#search_field');
        const q_res = document.querySelector('#search_result');
        const url = "<?php echo base_url('/search?q=') ?>" + term;

        if (document.querySelectorAll('.search-result')) {
            document.querySelectorAll(".search-result").forEach(el => el.remove());
        }

        fetch(url, {
                method: 'GET',
                headers: {
                    "X-CSRFToken": "<?= csrf_hash() ?>"
                }
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.body) {
                    if (data.body.length == 0) {
                        const element = document.createElement('div');
                        element.setAttribute('class', 'search-result card col-md-6 p-3');
                        element.innerHTML = '<h5>No Post Available.</h5>'

                        q_res.appendChild(element);
                    } else {
                        data.body.forEach(d => {
                            const element = document.createElement('div');
                            element.setAttribute('class', 'search-result card col-md-6 p-3');

                            const q_result = `
                                <h3>Posted by ` + d.author + `</h3>
                                <p>` + d.body + `</p>
                            `
                            element.innerHTML = q_result;

                            q_res.appendChild(element);
                        });
                    }
                } else {
                    const element = document.createElement('div');
                    element.setAttribute('class', 'search-result card col-md-6 p-3');
                    element.innerHTML = '<h5>Please Type the Keywords.</h5>'

                    q_res.appendChild(element);
                }
            });

    }
</script>
<?= $this->endSection() ?>