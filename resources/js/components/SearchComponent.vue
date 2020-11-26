<template>
    <form class="wt-formtheme wt-formbanner wt-formbannertwo" id="main-search-form" v-if="this.widget_type == 'home'">
        <fieldset>
            <div class="wt-dropdown"  @click="toggleDropdown">
                <span>{{trans('lang.in:')}} <em class="selected-search-type">{{selected_type}} </em><i class="lnr lnr-chevron-down"></i></span>
            </div>
            <div class="wt-radioholder" v-bind:style='{"display" : (isActive? "block" : "none" )}'>
                <span class="wt-radio" v-for="(filter, index) in filters" :key="index">
                    <input :id="'wt-freelancers'+index" type="radio" name="searchtype" :value="filter.value" v-model="types" v-on:change="getSearchableData(types), emptyField(types)">
                    <label :for="'wt-freelancers'+index">{{filter.title}}</label>
                </span>
            </div>
            <div class="form-group">
                <vue-bootstrap-typeahead
                    class="mb-4"
                    size="sm"
                    v-model="query"
                    :data="searchable_data"
                    placeholder="I’m looking for"
                    :serializer="item => item.name"
                    ref="searchfield"
                    @input="watchSearchResults"
                    inputClass="search-field"
                    @hit="recordSelected"
                >
                    <template slot="suggestion" slot-scope="{ data, htmlText }">
                        <div class="d-flex align-items-center">
                            <span class="ml-4" v-html="htmlText"></span>
                        </div>
                        <input type="hidden" name="keyword" :value="data.slug" id="hidden_field">
                    </template>
                </vue-bootstrap-typeahead>
                <span v-if="is_show" class="no-record-span">{{no_record}}</span>
                <div class="wt-formoptions">
                    <a href="#" class="wt-searchbtn" v-on:click.prevent="submitSearchForm"><i class="lnr lnr-magnifier"></i></a>
                </div>
            </div>
        </fieldset>
    </form>
    <form class="wt-formtheme wt-formbanner wt-formbannervtwo" v-else>
        <fieldset>
            <div class="form-group">
                <vue-bootstrap-typeahead
                    class="mb-4"
                    size="sm"
                    v-model="query"
                    :data="searchable_data"
                    placeholder="I’m looking for"
                    :serializer="item => item.name"
                    ref="searchfield"
                    @input="watchSearchResults"
                    inputClass="search-field"
                    @hit="recordSelected"
                >
                    <template slot="suggestion" slot-scope="{ data, htmlText }">
                    <div class="d-flex align-items-center">
                        <span class="ml-4" v-html="htmlText"></span>
                    </div>
                    <input type="hidden" name="keyword" :value="data.slug" id="hidden_field">
                </template>
            </vue-bootstrap-typeahead>
            <span v-if="is_show" class="no-record-span">{{no_record}}</span>
                <div class="wt-formoptions">
                    <div class="wt-dropdown"  @click="toggleDropdown">
                        <span>In: <em class="selected-search-type">{{selected_type}} </em><i class="lnr lnr-chevron-down"></i></span>
                    </div>
                    <div class="wt-radioholder" v-bind:style='{"display" : (isActive? "block" : "none" )}'>
                        <span class="wt-radio" v-for="(filter, index) in filters" :key="index">
                            <input :id="'wt-freelancers'+index" type="radio" name="searchtype" :value="filter.value" v-model="types" v-on:change="getSearchableData(types), emptyField(types)">
                            <label :for="'wt-freelancers'+index">{{filter.title}}</label>
                        </span>
                    </div>
                    <a href="#" class="wt-searchbtn" v-on:click.prevent="submitSearchForm"><i class="lnr lnr-magnifier"></i></a>
                </div>
            </div>
        </fieldset>
    </form>
</template>
<script>
 export default{
    props: ['widget_type'],
        data(){
            return {
                filters:[],
                isActive: false,
                searchable_data:[],
                freelancers:[],
                employers:[],
                jobs:[],
                query:'',
                types:'freelancer',
                selected_type:'freelancer',
                no_record:'no record found',
                is_show: false,
                related_results:false,
                url: APP_URL + '/search-results',
            }
        },
        methods: {
            getFilters(){
                let self = this;
                axios.get(APP_URL + '/search/get-search-filters')
                .then(function (response) {
                    if ( response.data.type == 'success') {
                        self.filters = response.data.result;
                    }
                });
            },
            getSearchableData: function(type, newQuery){
                let self = this;
                axios.post(APP_URL + '/search/get-searchable-data',{
                    type:type
                })
                .then(function (response) {
                    if (type == 'freelancer') {
                        self.searchable_data = response.data.searchables; 
                    } else if (type == 'employer') {
                        self.searchable_data = response.data.searchables; 
                    } else if (type == 'job') {
                        self.searchable_data = response.data.searchables; 
                        
                    }
                });
            },
            emptyField:function(types){
                this.$refs.searchfield.inputValue = '';
                this.selected_type = types;
                this.isActive = false;
            },
            watchSearchResults:function(){
                if(jQuery('.wt-radioholder').css('display') == 'block') {
                    jQuery('.wt-radioholder').css("display", "none");
                }
                if ( !(jQuery('.list-group').hasClass( "input-searching" )) ) {
                    jQuery('.list-group').addClass('input-searching');
                }
                if(this.$refs.searchfield.$children[0].matchedItems == '') {
                    jQuery('.search-field').parents('.form-group').find('span.no-record-span').css("display", "block");
                    jQuery('.wt-related-result').remove();
                    this.is_show = true;
                } else {
                    let keyword = this.query;
                    let type = this.types;
                    jQuery('.search-field').parents('.form-group').find('span.no-record-span').css("display", "none");
                    jQuery('.wt-related-result').remove();
                    var html = '<a href="'+this.url+'?s='+keyword+'&type='+type+'" class="wt-related-result"><span v-if="related_results">show all result related to'+' <em>'+ keyword+'</em></span></a>';
                    jQuery(".list-group").append(html);
                    this.related_results = true;
                    this.is_show = false;
                }
            },
            recordSelected:function(){
                if (jQuery('.list-group').hasClass( "input-searching" )) {
                    jQuery('.list-group').removeClass('input-searching');
                }
            },
            toggleDropdown: function(){
                if (this.isActive == false) {
                    this.isActive = true;
                    jQuery('.wt-related-result').remove();
                } else {
                    this.isActive = false;
                }
            },
            submitSearchForm: function() {
                let type = this.types;
                if (this.$refs.searchfield.inputValue != '') {
                    let slug = document.getElementById('hidden_field').value;
                    let keyword = this.query;
                    if (type == 'job') {
                        window.location.replace(APP_URL+'/job/'+slug);
                    } else {
                        window.location.replace(APP_URL+'/profile/'+slug);
                    }
                } else {
                     window.location.replace(APP_URL+'/search-results?type='+type);
                }
                
            },
        },
        watch: {
            query: _.debounce(function(newQuery) { this.getSearchableData(newQuery) }, 250)
        },
        mounted: function () {
            jQuery(".search-field").keydown(function(){
                var input = jQuery('.search-field');
                input.on('keydown', function() {
                    var key = event.keyCode || event.charCode;
                    if( key == 8 || key == 46 ) {
                        if(!jQuery(this).val()) {
                            jQuery(this).parents('.form-group').find('span.no-record-span').css("display", "none");
                        } else {
                            jQuery('.wt-related-result').remove();
                            this.is_show = true;
                        }
                    }
                });
            });
        },  
        created: function() {
            this.getFilters();
            this.getSearchableData('freelancer');
        } 
    }
</script>