<?= $this->extend('base') ?>

<?= $this->section('content') ?>

<div class="container" style="height: 100vh;">
    <div class="row h-100">
        <div class="col-5 mx-auto card p-3" id="login_card">
            <?php echo session()->get('status'); ?>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><?= session()->getFlashdata('error') ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <h3>Login Form</h3>
            <form action="<?php echo base_url('/login') ?>" method="POST">
                <div class="mb-3">
                    <label for="email_input" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="email_input" aria-describedby="email_help" required>
                    <div id="email_help" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="password_input" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password_input" required>
                </div>
                <button type="submit" class="btn btn-secondary">Submit</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>