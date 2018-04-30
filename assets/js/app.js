import Vue from 'vue';

// global component
Vue.component("my-volume", {
  
    template: "#volume-info",
    props: {
        active: 0,
        isActive: 1,
        volumeslist: {},
        show: {
          type: Boolean,
          required: true,
          twoWay: true
        }
    },
  
  methods: {
 
    // close modal
    setModalClose: function() {
        //this.show = false;
        //this.active = 0;
        
        //use emit instead of sync
        this.$emit('hide');
    }
  }
});

//Vue app
var app = new Vue({
    el: '#app',
    data: {
        term: '',
        volumes: [],
        volumesSorted: [],
        currentSort:'name',
        currentSortDir:'asc',
        pageSize: 10,
        currentPage:1,
        showModal: false,
        active: -1
    },
    methods:{
        search:function() {
            let vm = this;
                
            fetch('/api/v1/volumes?term=' + encodeURIComponent(this.term) )
            .then((response) => {
                
                //exit on status <> 200
                if (response.status != 200) {
                    alert("No results returned. Status " + response.status + " - " + response.statusText );
                    return;
                }
                 
                //parse json response 
                return response.json().then((json) => {
                    vm.volumes = json;
                    
                    this.sortList();
                })
              });
        },
        
        //sort and paginate data
        sortList: function() {
            
            this.volumesSorted = this.volumes.sort((a,b) => {
              let modifier = 1;
              if(this.currentSortDir === 'desc') modifier = -1;
              if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
              if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
              return 0;
            }).filter((row, index) => {
                let start = (this.currentPage-1)*this.pageSize;
		let end = this.currentPage*this.pageSize;
		if((index >= start) && (index < end)) return true;
            });
            
        },
        
        //set sort field and direction 
        sort:function(s) {
            
            if(s === this.currentSort) {
              this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
            }
            this.currentSort = s;
            
            this.sortList();
            
            return;
        },
        
        //go to next page - set bottom and upper limit of collection
        nextPage:function() {
            if((this.currentPage*this.pageSize) < this.volumes.length) this.currentPage++;
            
            this.sortList();
            
            return;
        },
        
        //go to previous page - set bottom and upper limit of collection
        prevPage:function() {
            if(this.currentPage > 1) this.currentPage--;
            
            this.sortList();
            
            return;
        },
        
        //open modal popup - set showModal and active true
        modalOpen: function(i) {
            this.showModal = true; 
            return this.active = i;
          },
                 
      }
});