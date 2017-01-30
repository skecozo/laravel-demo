

export const setUserInfo=({ commit }, user) =>commit('setUserInfo', user);
export const logoutuser=({ commit }) =>commit('logoutuser');

export const serachArticle=({ commit }, serachdata) =>commit('serachArticle', serachdata);

export const getuserinfo=({ commit }) =>{
    Vue.http.get('/api/user/getuserinfo' )
        .then((response) => {
            console.log(response.data);
            localStorage.setItem('user', JSON.stringify(response.data.data));
            commit('getuserinfo', {
                userInfo:response.data.data
            })
        })
}


