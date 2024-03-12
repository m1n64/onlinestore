<template>
    <AuthWithBgLayout>
        <template v-for="(user, key) in users" :key="key">
            <div class="flex justify-between border-b-2 border-solid border-b-gray-300 my-4">
                <div>
                    <div class="">
                        {{ user.id }}. {{ user.name }}
                        <span class="text-gray-600" v-show="user.id === $page.props.auth.user.id">(you)</span>
                    </div>
                    <div class="text-gray-700"> {{ user.email }}</div>
                    <div :class="getColorByRole(user.role)">Role: {{ user.role_name }}</div>
                    <div :class="!!user.is_banned ? 'font-bold text-red-600' : ''">Is banned: {{ !!user.is_banned }}</div>
                    <div>Max files size: {{ user.max_files_size === -1 ? 'Unlimited' : user.max_files_size }} MB</div>
                    <div>Current files size: {{ user.files_size }} MB</div>
                </div>
                <div v-show="user.id !== $page.props.auth.user.id">
                    <div class="my-2">
                        <select :ref="'role-select-'+user.id">
                            <template v-for="(role, key) in roles" :key="key">
                                <option :value="role.role" :selected="user.role === role.role">{{ role.name }}</option>
                            </template>
                        </select>
                        <button class="btn main" @click="changeStatus(user.id, key)">Save</button>
                    </div>
                    <div class="">
                        <button class="btn sub" @click="setBanStatus(user.id, key, !user.is_banned)">{{ !user.is_banned ? 'Ban' : 'Unban' }}</button>
                    </div>
                    <div v-show="user.role !== 'A'">
                        <input
                            :ref="'max-files-size-'+user.id"
                            type="number"
                            step="0.01"
                            class="my-2 block w-3/4"
                            placeholder="Max file size"
                            :value="user.max_files_size"
                        />
                        <button class="btn main" @click="setMaxFilesSize(user.id, key)">Set max storage size (MB)</button>
                    </div>
                </div>
            </div>
        </template>
    </AuthWithBgLayout>

</template>

<script>
import AuthWithBgLayout from "@/Layouts/AuthWithBgLayout.vue";
import {ref} from "vue";
import {getCookie} from "@/cookies";
import TextInput from "@/Components/TextInput.vue";

export default {
    name: "Users",
    components: {TextInput, AuthWithBgLayout},
    setup() {
        const roles = ref([
            {
                role: "U",
                name: "User"
            },
            /*{
                role: "M",
                name: "Moder"
            },*/
            {
                role: "A",
                name: "Admin"
            }
        ]);

        return {roles};
    },
    props: {
        users: Array
    },
    methods: {
        setNewUserState(key, state) {
            this.$props.users[key] = state;
        },

        getColorByRole(role) {
            switch (role) {
                default:
                case "U":
                    return "text-green-600";
                case "M":
                    return "text-blue-600";
                case "A":
                    return "text-red-600"
            }
        },

        /**
         * @param {string} id
         * @param {*} key
         */
        changeStatus(id, key) {
            const userRole = this.$refs['role-select-' + id][0].value;

            axios.post("/api/admin/setRole/" + id, {
                role: userRole
            }, {
                headers: {
                    "Authorization": `Bearer ${getCookie("__token")}`
                }
            })
                .then((resp) => {
                    if (resp.data.success) {
                       this.setNewUserState(key, resp.data.data);
                    }
                })
        },

        /**
         * @param {string} id
         * @param {*} key
         * @param {boolean} status
         */
        setBanStatus(id, key, status) {
            axios.post("/api/admin/setBanStatus/" + id, {
                status: status
            }, {
                headers: {
                    "Authorization": `Bearer ${getCookie("__token")}`
                }
            })
                .then((resp) => {
                    if (resp.data.success) {
                        this.setNewUserState(key, resp.data.data);
                    }
                })
        },

        setMaxFilesSize(id, key) {
            const maxSize = this.$refs['max-files-size-' + id][0].value;

            axios.post("/api/admin/setMaxFilesSize/" + id, {
                max_size: maxSize
            }, {
                headers: {
                    "Authorization": `Bearer ${getCookie("__token")}`
                }
            })
                .then((resp) => {
                    if (resp.data.success) {
                        this.setNewUserState(key, resp.data.data);
                    }
                })
        }
    }
}
</script>

<style scoped>

</style>
