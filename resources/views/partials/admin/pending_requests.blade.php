<div class="container col-lg-6 col-xs-10 col-md-10 col-sm-10" id="pending-content">
    <div class="admin-section-title"> Registos </div>
    <ul class="list-group">
    @each('partials.admin.common.pending_request', $requests, 'request')
    </ul>
</div>