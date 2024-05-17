import Cookies from "js-cookie"

export default function hasLoggedIn({ next, router, to }) {
    if (!Cookies.get('access_token_fat')) {
        return router.push('/auth/login');
    }
    let settingViews = localStorage.getItem('setting_views');
    if (settingViews) {
        settingViews = JSON.parse(settingViews);
        if (settingViews.length > 0) {
            let toPath = to.name
            if (toPath.includes('manufacture')) {
                toPath = toPath.split('-')[0]
            }
            const settingV = settingViews.find(x => x.label.includes(toPath))
            if (settingV !== undefined) {
                if (settingV.is_show !== 1) {
                    return router.push('/app');
                }
            }
        }
    }
    console.log("check login", localStorage.getItem('setting_views') === null)
    return next();
}
