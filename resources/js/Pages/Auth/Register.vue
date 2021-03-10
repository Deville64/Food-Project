<template>
    <main id="log" class="wrapper">
        <inertia-link href="/" id="logo">Onylia</inertia-link>

        <h1>Inscription</h1>

        <breeze-validation-errors />

        <form @submit.prevent="submit">
            <div class="group">
                <breeze-input type="email" v-model="form.email" required autocomplete="username" />
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="email">Adresse email</label>
            </div>

            <div class="group">
                <breeze-input type="password" v-model="form.password" required autocomplete="new-password" />
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="password">Mot de passe</label>
            </div>

            <breeze-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">S'inscrire</breeze-button>
        </form>

        <div id="other">
            <p>Vous êtes déjà inscrit ?</p>
            <inertia-link href="login">Connectez-vous</inertia-link>
        </div>
    </main>
</template>

<script>
    import BreezeButton from '@/Components/Button'
    import BreezeInput from '@/Components/Input'
    import BreezeValidationErrors from '@/Components/ValidationErrors'

    export default {
        components: {
            BreezeButton,
            BreezeInput,
            BreezeValidationErrors,
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>


<style lang="scss" scoped>
    #logo {
    display: block;
    color: #48bc8b;
    font-weight: 600;
    font-size: 20px;
    text-transform: uppercase;
    margin-top: 18px;
    margin-bottom: 80px;
}

h1 {
    text-align: center;
    font-size: 25px;
    font-weight: 600;
    margin-bottom: 55px;
}

form{
    width: 300px;
    margin: auto;
    text-align: center;
    margin-bottom: 55px;
}

#other{
    text-align: center;
}
#other a{
    display: block;
    margin-bottom: 18px;
}



// INPUT STYLE
/* form starting stylings ------------------------------- */
.group {
    position: relative;
    margin-bottom: 45px;
}
.group input {
    font-size: 18px;
    padding: 10px 10px 10px 5px;
    display: block;
    width: 300px;
    border: none;
    border-bottom: 1px solid #757575;
}
input:focus {
    outline: none;
}

/* LABEL ======================================= */
.group label {
    color: #999;
    font-size: 18px;
    font-weight: normal;
    position: absolute;
    pointer-events: none;
    left: 5px;
    top: 10px;
    transition: 0.2s ease all;
    -moz-transition: 0.2s ease all;
    -webkit-transition: 0.2s ease all;
}

/* active state */
 .group input:focus ~ label,
 .group input:valid ~ label {
    top: -20px;
    font-size: 14px;
    color: #48bc8b;
}

/* BOTTOM BARS ================================= */
 .bar {
    position: relative;
    display: block;
    width: 300px;
}
 .bar:before,
 .bar:after {
    content: "";
    height: 2px;
    width: 0;
    bottom: 1px;
    position: absolute;
    background:#48bc8b;
    transition: 0.2s ease all;
    -moz-transition: 0.2s ease all;
    -webkit-transition: 0.2s ease all;
}
 .bar:before {
    left: 50%;
}
 .bar:after {
    right: 50%;
}

/* active state */
 input:focus ~ .bar:before,
 input:focus ~ .bar:after {
    width: 50%;
}

/* HIGHLIGHTER ================================== */
 .highlight {
    position: absolute;
    height: 60%;
    width: 100px;
    top: 25%;
    left: 0;
    pointer-events: none;
    opacity: 0.5;
}

/* active state */
 .group input:focus ~ .highlight {
    -webkit-animation: inputHighlighter 0.3s ease;
    -moz-animation: inputHighlighter 0.3s ease;
    animation: inputHighlighter 0.3s ease;
}

/* ANIMATIONS ================ */
@-webkit-keyframes inputHighlighter {
    from {
        background: #48bc8b;
    }
    to {
        width: 0;
        background: transparent;
    }
}
@-moz-keyframes inputHighlighter {
    from {
        background: #48bc8b;
    }
    to {
        width: 0;
        background: transparent;
    }
}
@keyframes inputHighlighter {
    from {
        background: #48bc8b;
    }
    to {
        width: 0;
        background: transparent;
    }
}

</style>