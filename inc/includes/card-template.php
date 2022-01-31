<template id="card-template">
    <article class="col-lg-3 col-md-4 col-sm-6 cardcol">
        <div class="card classfield-card-preview">
            <div style="background: url('/assets/images/classfields/%photo_hash%'); background-size: cover; background-position: center;" class="classfieldimage">
                <div class="cost-badge ">%cost%</div>
            </div>
            <div class="card-body">
                <a href="%link%" class="card-title stretched-link">%title%</a>
                <p class="card-text"><small class="text-muted"><i class="fas fa-map-marker-alt"></i> %location%</small></p>
            </div>
        </div>
</article>
</template>