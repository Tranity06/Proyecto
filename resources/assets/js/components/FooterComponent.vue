<template>
    <footer class="footer">
        <div class="container">
            <div class="content has-text-centered">
                <span class="marca">Palomitas Time</span>
                <div class="redes">
                    <a href="http://www.twitter.com" class="centeredIcon twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="http://www.facebook.com" class="centeredIcon facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="http://www.facebook.com" class="centeredIcon instagram">
                        <i class="fab fa-instagram"></i>
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

    .content{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    @media (max-width: 700px) {
        .content{
            flex-direction: column;
        }
    }

    .marca{
        font-family: 'Jua', sans-serif !important;
        font-size: 1.5rem;
    }

    .redes{
        display: flex;
        min-width: 250px;
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
        background-color: white;
        border-radius: 100%;
        margin-left: .5rem;
        -webkit-transition: all .5s;
        -moz-transition: all .5s;
        transition: all .5s;
    }

    .facebook{
        color: #3b5998;
    }

    .twitter{
        color: #15a7ff;
    }

    .facebook:hover {
        color: white;
        background-color: #3b5998;
    }


    .twitter:hover {
        color: white;
        background-color: #15a7ff;
    }

    .instagram{
        color: #bc2a8d;
    }

    .instagram:hover{
        color: white;
        background-color: #bc2a8d;
    }

</style>