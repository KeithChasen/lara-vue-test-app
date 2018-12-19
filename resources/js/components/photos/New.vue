<template>
    <div>
        <form>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" id="photo" name="photo" class="form-control-file" @change="onFileChanged">
            </div>
            <button @click.prevent="upload" class="btn btn-primary">Upload</button>
        </form>
    </div>
</template>

<script>
    export default {
        name: "photo-new",
        data() {
          return {
              selectedFile: null
          }
        },
        methods: {
            onFileChanged(event){
                this.selectedFile = event.target.files[0]
            },
            upload() {
                const formData = new FormData();
                formData.append('photo', this.selectedFile, this.selectedFile.name);
                axios.post('/api/photos', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then((response) => {
                        this.$router.push('/admin/photos');
                    });
            }
        }
    }
</script>

<style scoped>

</style>
