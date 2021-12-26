<p class="card-title-custom">OGŁOSZENIA</p>

<table id="table" data-search="true" data-pagination="true" data-page-size="8" data-show-custom-view="true" data-custom-view="customViewFormatter">
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
<template id="card-template">
    <div class="col-lg-3 col-md-6 col-sm-6 cardcol">
        <div class="card classfield-card-preview">
            <div style="background: url('/assets/images/test-dogs/%photo_hash%'); background-size: cover; background-position: center;" class="classfieldimage"></div>
            <div class="card-body">
                <a href="%link%" class="card-title">%title%</a>
                <p class="card-text"><small class="text-muted"><i class="fas fa-map-marker-alt"></i> %location%</small></p>
            </div>
        </div>
    </div>
</template>