<button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter" aria-controls="offcanvasExample">
    <i class="fas fa-filter"></i> Filtry wyszukiwania
</button>
<table id="table" data-search="true" data-server-sort="true" data-pagination="true" data-page-size="48" data-side-pagination="server" ata-server-sort="false" data-query-params="queryParams" data-show-custom-view="true" data-custom-view="customViewFormatter">
    <thead>
        <tr>
            <th data-field="id">id</th>
            <th data-field="title">title</th>
            <th data-field="location">location</th>
            <th data-field="cost">cost</th>
            <th data-field="photo_hash">photo_hash</th>
            <th data-field="link">link</th>
            <th data-field="created_at">created_at</th>
        </tr>
    </thead>
</table>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/card-template.php');
?>