import Cookies from "js-cookie"

export default function hasLoggedIn({ next, router, to }) {
    if (!Cookies.get('access_token')) {
        return router.push('/auth/login');
    }
    console.log("haslogin")
    return next();
}
