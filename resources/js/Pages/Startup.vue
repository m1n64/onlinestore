<template>
    <Head title="Online Store" />

    <div class="bg-gradient-to-tl from-slate-300 to-gray-200 h-screen"
        style=""
    >
        <div class="flex justify-center pt-[25vh] mb-[5%]">
            <div class="text-6xl border-b-4 border-solid border-b-indigo-400">
                <div class="text-5xl font-extrabold">
                  <span class="bg-clip-text text-transparent bg-gradient-to-r from-pink-500 to-violet-500">
                    ONLINE-STORE
                  </span>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap justify-center mb-[5%]">
            <div class="card w-[33%]">
                <font-awesome-icon icon="fa-solid fa-gauge-simple-high" />
                Fast storage
            </div>
            <div class="card w-[33%]">
                <font-awesome-icon icon="fa-solid fa-database" />
                Free 100 MB
            </div>
            <div class="card w-[33%]">
                <font-awesome-icon icon="fa-solid fa-shield" />
                Safety data
            </div>
            <div class="card w-[33%]">
                <font-awesome-icon icon="fa-solid fa-paper-plane" />
                Sharing files
            </div>
        </div>

        <div v-if="canLogin" class="hidden sm:flex justify-center text-2xl">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="btn main"
            >Open</Link>

            <template v-else>
                <Link :href="route('login')" class="btn sub">Log in</Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="btn main"
                >Register</Link>
            </template>
        </div>

    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

export default {
    name: "Startup",
    components: {
        FontAwesomeIcon,
        Head,
        Link
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    }
}
</script>

<style scoped>

</style>
