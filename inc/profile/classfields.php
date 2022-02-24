<p class="card-title-custom">OGŁOSZENIA</p>

<table id="table" data-pagination="true" data-page-size="8" data-show-custom-view="true" data-custom-view="customViewFormatter" data-query-params="queryParams">
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