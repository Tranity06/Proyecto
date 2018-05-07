<template>
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-10-tablet is-offset-2-tablet">
                    <img :src="'uploads/avatars/'+avatar"
                         style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
                    <h2> <b>{{ userName }}</b> Perfil</h2>
                    <form enctype="multipart/form-data">
                        <label>Cambiar avatar</label>
                        <input type="file" name="avatar">
                        <input type="submit" class="button" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    export default {
        data() {
            return {
                avatar: '',
                userName: '',
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
        mounted(){
            this.avatar = JSON.parse(localStorage.getItem('user')).avatar;
            this.userName = JSON.parse(localStorage.getItem('user')).name;
        }
    }
</script>