
{{ content() }}

<div class="jumbotron">
    <h1>Unauthorized</h1>
    <p>You don't have access to this option. Contact an administrator</p>
    <p>{{ link_to('../qm/login.php?fr='~request.getURI(), 'Login with account which has permission', 'class': 'btn btn-primary') }}</p>
</div>