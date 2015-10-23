<form class="container" action="<?php echo $this->action('proceed'); ?>" method="post">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <p>You are trying to access a password protected area. Know the password?</p>
            <div class="form-group">
                <label class="sr-only">Password Required</label>
                <input type="password" name="_password" class="form-control input-lg" placeholder="Password" />
                <input type="hidden" name="resource" value="<?php echo $resource; ?>" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 text-center">
            <button type="submit" class="btn btn-success btn-lg">Go</button>
        </div>
    </div>
</form>