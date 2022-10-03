import Vue from "vue";
import Router from "vue-router";
import ProjectsList from "../components/pages/ProjectsList";
import WorkArea from "../components/pages/WorkArea";
import Notifications from "../components/pages/Notifications";
import Analytics from "../components/pages/Analytics";
import Settings from "../components/pages/Settings";
import ProjectDetail from "../components/pages/ProjectDetail";
import Profile from "../components/pages/Profile";
import FAQ from "../components/pages/FAQ";
import Login from "../components/auth/Login";
import Reset from "../components/auth/Reset";
import Register from "../components/auth/Register";
import Logout from "../components/auth/Logout";
import Support from "../components/pages/Support";
import AddNewProject from "../components/pages/AddNewProject";
import Finance from "../components/pages/Finance";

Vue.use(Router);

export default new Router({
    base: '/home',
    mode: 'history',
    routes: [
        {
            name: 'login',
            path: '/login',
            component: Login
        },
        {
            name: 'reset',
            path: '/reset',
            component: Reset
        },
        {
            name: 'logout',
            path: '/logout',
            component: Logout
        },
        {
            name: 'register',
            path: '/register',
            component: Register
        },
        {
            name: "work-area",
            path: "/",
            component: WorkArea,
            meta: {
                auth: true
            }
        },
        {
            name: "profile",
            path: "/profile",
            component: Profile,
            meta: {
                auth: true
            }
        },
        {
            name: "FAQ",
            path: "/faq",
            component: FAQ,
            meta: {
                auth: true
            }
        },
        {
            name: "support",
            path: "/support",
            component: Support,
            meta: {
                auth: true
            }
        },
        {
            name: "projects-list",
            path: "/projects",
            component: ProjectsList,
            meta: {
                auth: true
            }
        },
        {
            name: "add-project",
            path: "/add-project",
            component: AddNewProject,
            meta: {
                auth: true
            }
        },
        {
            name: "project-detail",
            path: "/projects/:id",
            component: ProjectDetail,
            meta: {
                auth: true
            }
        },
        {
            name: "notifications",
            path: "/notifications",
            component: Notifications,
            meta: {
                auth: true
            }
        },
        {
            name: "finance",
            path: "/finance",
            component: Finance,
            meta: {
                auth: true
            }
        },
        {
            name: "analytics",
            path: "/analytics",
            component: Analytics,
            meta: {
                auth: true
            }
        },
        {
            name: "settings",
            path: "/settings",
            component: Settings,
            meta: {
                auth: true
            }
        },

    ]
})
