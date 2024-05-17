import Cookies from "js-cookie"

export default function hasLoggedInBackend({ next, router, to }) {
    if (!Cookies.get('access_token_backend_fat')) {
        return router.push('/backend/auth/login');
    }
    return next();
}
