<template>
    <div class="page">
        <div class="row mb-0">
            <div class="col-12" style="margin-bottom: -10px;">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4><span class="mb-0 font-size-13 font-weight-bold">Scholar Profile</span></h4>

                    <div class="page-title-right font-size-11">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item"><router-link :to="{ name: 'scholar/lists' }">Scholars</router-link></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <scholar-profile></scholar-profile>
    </div>
</template>

<script>
    export default {
        
    }
</script>
