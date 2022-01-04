<template>
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>
                <li @click="selected = 1" :class="{'mm-active':selected == 1}">
                    <router-link :to="{ name: 'home' }" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </router-link>
                </li>
                <li @click="selected = 2" :class="{'mm-active':selected == 2}">
                    <router-link :to="{ name: 'user' }" class="waves-effect">
                        <i class="bx bxs-user-circle"></i>
                        <span key="t-dashboards">User</span>
                    </router-link>
                </li>
                <li @click="selected = 3" :class="{'mm-active':selected == 3}">
                    <router-link :to="{ name: 'logs' }" class="waves-effect">
                        <i class="bx bx-message-square-dots"></i>
                        <span key="t-dashboards">Logs</span>
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data(){
            return {
                selected : 1
            }
        }
    }
</script>