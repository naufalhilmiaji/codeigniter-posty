<?php
header('Content-Type: application/javascript');
?>
function editPost(id) {
    const textareaField = `
            <form action="<?php echo base_url('/update/') . '/' ?>` + id + `" id="edit_form_` + id + `" method="post">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Write your content here."id="body_edit_`+ id + `"
                                name="body_edit" style="height: 200px;"></textarea>
                    <label for="body_edit_`+ id + `">Edit Content</label>
                </div>

                <button type="submit" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary" id="cancel_edit_`+ id + `"
                        onclick="cancelEdit(`+ id + `)">Cancel</button>
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
            const bodyEdit = document.querySelector('#body_edit_' + id);
            bodyEdit.value = data.body.body.replaceAll('<br />', '');
        });
}

function cancelEdit(id) {
    const textValue = document.querySelector('#body_edit_' + id).value;
    const post = document.querySelector('#edit_form_' + id);

    const postBody = `
            <blockquote class="blockquote mb-0" id="blockquote_`+ id + `">
                <p id="body_`+ id + `">` + textValue + `</p>
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
                    element.setAttribute('class', 'search-result card shadow p-3 mb-5 bg-body rounded col-md-6 p-3');
                    element.innerHTML = '<h5>No Post Available.</h5>'

                    q_res.appendChild(element);
                } else {
                    data.body.forEach(d => {
                        const element = document.createElement('div');
                        element.setAttribute('class', 'search-result card shadow p-3 mb-5 bg-body rounded col-md-6 p-3');

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
                element.setAttribute('class', 'search-result card shadow p-3 mb-5 bg-body rounded col-md-6 p-3');
                element.innerHTML = '<h5>Please Type the Keywords.</h5>'

                q_res.appendChild(element);
            }
        });

}