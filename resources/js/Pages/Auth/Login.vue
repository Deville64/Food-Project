<template>
  <main id="log" class="wrapper">
    <inertia-link href="/" id="logo">Onylia</inertia-link>

    <h1>Connexion</h1>

    <breeze-validation-errors />

    <form @submit.prevent="submit">
        <div class="group">
        <breeze-input type="email" v-model="form.email" required autofocus autocomplete="username" />
        <span class="highlight"></span>
        <span class="bar"></span>
        <label for="email">Adresse email</label>
      </div>

      <div class="group">
        <breeze-input type="password" v-model="form.password" required autocomplete="current-password" />
        <span class="highlight"></span>
        <span class="bar"></span>
        <label for="password">Mot de passe</label>
      </div>

      <breeze-button  :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Se connecter
      </breeze-button>
    </form>

    <div id="other">
        <p>Vous n'êtes pas inscrit ?</p>
        <inertia-link href="register">Créer un compte</inertia-link>
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
            BreezeValidationErrors
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>

<style lang="scss" scoped>
#log #logo {
    display: block;
    color: #48bc8b;
    font-weight: 600;
    font-size: 20px;
    text-transform: uppercase;
    margin-top: 18px;
    margin-bottom: 80px;
}

#log h1 {
    text-align: center;
    font-size: 25px;
    font-weight: 600;
    margin-bottom: 55px;
}

#log form{
    width: 300px;
    margin: auto;
    text-align: center;
    margin-bottom: 55px;
}

#log #other{
    text-align: center;
}
#log #other a{
    display: block;
    margin-bottom: 18px;
}




// INPUT STYLE
/* form starting stylings ------------------------------- */
#log .group {
    position: relative;
    margin-bottom: 45px;
}
#log .group input {
    font-size: 18px;
    padding: 10px 10px 10px 5px;
    display: block;
    width: 300px;
    border: none;
    border-bottom: 1px solid #757575;
}
#log input:focus {
    outline: none;
}

/* LABEL ======================================= */
#log .group label {
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
#log .group input:focus ~ label,
#log .group input:valid ~ label {
    top: -20px;
    font-size: 14px;
    color: #48bc8b;
}

/* BOTTOM BARS ================================= */
#log .bar {
    position: relative;
    display: block;
    width: 300px;
}
#log .bar:before,
#log .bar:after {
    content: "";
    height: 2px;
    width: 0;
    bottom: 1px;
    position: absolute;
    background: #48bc8b;
    transition: 0.2s ease all;
    -moz-transition: 0.2s ease all;
    -webkit-transition: 0.2s ease all;
}
#log .bar:before {
    left: 50%;
}
#log .bar:after {
    right: 50%;
}

/* active state */
#log input:focus ~ .bar:before,
#log input:focus ~ .bar:after {
    width: 50%;
}

/* HIGHLIGHTER ================================== */
#log .highlight {
    position: absolute;
    height: 60%;
    width: 100px;
    top: 25%;
    left: 0;
    pointer-events: none;
    opacity: 0.5;
}

/* active state */
#log .group input:focus ~ .highlight {
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