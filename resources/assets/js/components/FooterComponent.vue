<template>
    <footer class="footer">
        <div class="container">
            <div class="content has-text-centered">
                <span class="marca">Palomitas Time</span>
                <div class="redes">
                    <a href="http://www.twitter.com" class="centeredIcon">
                        <i class="fab fa-twitter-f"></i>
                    </a>
                    <a href="http://www.facebook.com" class="centeredIcon">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="http://www.facebook.com" class="centeredIcon">
                        <i class="fab fa-instagram-f"></i>
                    </a>
                </div>
                <span><b>2018 PALOMITASTIME.COM</b></span>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        name: "footer-component"
    }
</script>

<style scoped>

    .marca{
        font-family: 'Jua', sans-serif !important;
        font-size: 1.5rem;
    }

    .redes{
        display: flex;
        max-width: 300px;
        justify-content: space-between;
    }

    .centeredIcon {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        width: 40px;
        height: 40px;
        color: dodgerblue;
        background-color: ghostwhite;
        border-radius: 100%;
        margin-left: .5rem;
        -webkit-transition: all .5s;
        -moz-transition: all .5s;
        transition: all .5s;
    }

    .centeredIcon:hover {
        color: white;
        background-color: dodgerblue;
    }
</style>