// Volumeslist.vue

<template>
    <div>
        <input v-model="term" type="search">
        <button @click="search">Search</button>
        <p/>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>
                    Name
                </th>
                <th>
                    Author
                </th>
                <th>
                    Description
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="volume in volumeData">
                <td>
                    {{ volume.name }}
                </td>
                <td>
                    {{ volume.author }}
                </td>
                <td>
                    {{ volume.description }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
      name: 'volumes-list',
      props: {
        volumes: {required: true},
        term: ''
      },
      data: function () {
        return {
            volumeData: this.volumes
        }
      },
      methods:{
		search:function() {
                        let vm = this;
			this.searching = true;
                        fetch('/api/v1/volumes')
                        .then((response) => {
                            return response.json().then((json) => {
                                console.log("JSON",json);
                                vm.volumes = json;
                              
                            })
                          });
		}
	}
    };
</script>
