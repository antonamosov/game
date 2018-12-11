<template>
    <div class="container" id="main">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{ pageName }}</strong><br>
                        {{ pageDescription }}
                    </div>

                    <div class="panel-body">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex';


    export default {

        computed: mapState([
            'pageName',
            'pageDescription'
        ]),

    }
</script>