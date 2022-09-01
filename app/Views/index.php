<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title)?></title>
</head>
<body>
    <?php if (session()->get('logged_in') == 1) : ?>
        <a href="<?php echo base_url('/logout') ?>">Logout</a>
        <h1>Hai, <?php print_r(session()->get('name')); ?></h1>
    <?php else : ?>
        <a href="<?php echo base_url('/login') ?>">Login</a>
    <?php endif; ?>

    <h3>Posts</h3>
    <table>
        <thead>
            <tr>
                <th>Post ID</th>
                <th>Body</th>
                <th>Author</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($posts as $post):?>
                <tr>
                    <td><?= $post['post_id']?></td>
                    <td><?= $post['body'];?></td>
                    <td><?= $post['author'];?></td>
                    <td><?= date('d/m/Y H:i:s', strtotime($post['created_at']));?></td>
                    <td><button type="button" id="<?= 'edit_button_' . $post['post_id'] ?>" onclick="editPost(<?= $post['post_id']?>);">Edit</button></td>
                    <td><button type="button" id="<?= 'del_button_' . $post['post_id'] ?>" onclick="delPost(<?= $post['post_id']?>)">Delete</button></td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <div class="insert-field" id="insert_field">
        <form action="<?php echo base_url('/upload') ?>" method="POST">
            <input type="text" name="body">
            <button type="submit">Save</button>
        </form>
    </div>
    <hr id="horizontal">
    <form action="" method="POST" id="del_form"></form>
    <h3>Search Post</h3>
    <div class="search-field" id="search_field">
        <input type="text" name="body" id="q_term">
        <button type="button" id="search_btn" onclick="searchPost()">Search</button>
    </div>
    <form action="" method="POST" id="search_form"></form>
</body>
<script>
    function editPost(id) {
        let insertField = document.querySelector('#horizontal');
        if (document.querySelector('#edit_field')) {
            document.querySelector('#edit_field').remove()
        }
        const url = "<?php echo base_url('/edit/') . '/' ?>" + id;

        const inputUpdate = `
            <div class="edit-field" id="edit_field">
                <h3>Update Fields</h3>
                <form action="<?php echo base_url('/update/') . '/' ?>`+ id +`" method="post">
                    <label for="body_edit">Content:</label>
                    <input type="text" name="body_edit" id="body_edit">
                    <br><br >
                    <label for="body_edit">Author:</label>
                    <input type="text" name="author_edit" id="author_edit">
                    <br><br>
                    <button type="submit">Save</button>
                </form>
            </div>
        `

        insertField.insertAdjacentHTML("afterend", inputUpdate);

        fetch(url, {method: 'GET',})
            .then((response) => response.json())
            .then((data) => {
                const bodyEdit = document.querySelector('#body_edit')
                const authorEdit = document.querySelector('#author_edit')

                bodyEdit.value = data.body.body;
                authorEdit.value = data.body.author;
        });
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
        const url = "<?php echo base_url('/search?q=') ?>" + term;

        if (document.querySelectorAll('.search-result')) {
            document.querySelectorAll(".search-result").forEach(el => el.remove());
        }

        fetch(url, {method: 'GET',})
            .then((response) => response.json())
            .then((data) => {
                if (data.body.length == 0) {
                    const q_result = `
                        <div class="search-result" id="search_result" style="border: 1px solid black; padding: 1rem; margin: 1rem 0; width: 30rem;">
                            <h3>No post available.</h3>
                        </div>
                    `
                
                    q_div.insertAdjacentHTML("afterend", q_result);
                } else {
                    data.body.forEach(d => {
                        const q_result = `
                            <div class="search-result" id="search_result" style="border: 1px solid black; padding: 1rem; margin: 1rem 0; width: 30rem;">
                                <h3>Posted by `+ d.author +`</h3>
                                <p>` + d.body +`</p>
                            </div>
                        `
                    
                        q_div.insertAdjacentHTML("afterend", q_result);
                    });
                }
            })
        
    }
</script>
</html>