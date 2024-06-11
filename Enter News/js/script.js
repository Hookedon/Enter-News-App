new Vue({
    el: '#app',
    data: {
        comunidadB_ID:-1,
        comunidadB_N:"",
        relevanciaB: -1,
        veracidadB: -1,
        email: "",
        password: "",
        username: "",
        interesesUsuario:'[]',
        sesion: 0,
        currentPage: "",
        idBuscado: "",
        isNavOpen: false,
        nuevaComunidad: {
            nombre: "",
            usuario:"",
            razon: ""
        },
        noticias: [],
        comunidades: [],
        nuevaNoticia: {
            titulo: "",
            autor: "",
            url: "",
            veracidad: -1,
            relevancia: -1,
            comunidad: -1,
            fecha_publicacion: "",
            sinopsis: ""
        },
        noticiasCoinciden:[],
        selectedNews: {},
        noticiasNoAProbadas:[],
        comunidadesNoApro:[],
        
    },
    methods: {
        aprobarComunidad(comunidad){
            this.nuevaComunidad = {
                nombre_comunidad: comunidad.nombre_comunidad,
                usuario: comunidad.usuario,
                razon: comunidad.razon

            };
            fetch('http://localhost:8000/api/comunidades', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52'
                },
                body: JSON.stringify({"nombre_comunidad":this.nuevaComunidad.nombre_comunidad})
            })
            .then(response => response.json())
            .then(responseData => {
                if (responseData.status) {
                    console.log('Comunidad aprobada y agregada correctamente!');
                
                    fetch(`http://localhost:8000/api/comunidadesNoConfirmadas/${comunidad.id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52'
                        }
                    });
                } else {
                    console.error('Failed to approve the noticia.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
            this.nuevaComunidad = {
                nombre_comunidad: "",
                usuario:"",
                razon: ""

            };
            this.getcomunidadesNoApr();
        },
        eliminarComunidad(comunidad){
            fetch(`http://localhost:8000/api/comunidadesNoConfirmadas/${comunidad.id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52'
                }
            });
            this.getcomunidadesNoApr();
        },
        agregarNoticiaAEliminadas(data) {
            console.log(JSON.stringify(data));
            fetch(`http://localhost:8000/api/noticiasNoConfirmadas/${data.id}/archive`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52'
                },

                
            })
            .then(response => response.json())
            .then(responseData => {
                if (responseData.status) {
                    console.log('Noticia archivada y borrada correctamente!');
                } else {
                    console.error('Failed to archive and delete the noticia.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        },
        modificarNoticia(noticia) {
            this.selectedNews = noticia;
            this.currentPage = 'modificar-noticia';
            this.getComunidades();
        },
        
        submitModificacion(data) {
            console.log(data);

            fetch('http://localhost:8000/api/news', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(responseData => {
                if (responseData.status) {
                    console.log('Noticia modificada y agregada correctamente!');
                    // Move the original noticia to noticiasEliminadas

                    this.agregarNoticiaAEliminadas(data);
                } else {
                    console.error('Failed to modify the noticia.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        },
        
        aprobarNoticia(data) {
            console.log(data);
            //data.noticias.id=null;
            fetch('http://localhost:8000/api/news', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(responseData => {
                if (responseData.status) {
                    console.log('Noticia aprobada y agregada correctamente!');
        
                    // Delete the original noticia from noticiasNoConfirmadas
                    fetch(`http://localhost:8000/api/noticiasNoConfirmadas/${data.id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52'
                        }
                    });
                } else {
                    console.error('Failed to approve the noticia.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        },
        //NAVEGACION///////////////////////////////////////////////////////////////////////////////////////////////////////
        toggleNav(){this.isNavOpen = !this.isNavOpen;},
        changePage(page) {////////////////////cambia las paginas y hace que funcionen ////////////////////////////////
            this.currentPage = page;
            this.isNavOpen = false;
            switch(page) {
                case "intereses":
                    //this.getNoticiasIntereses();
                    break;
                case "buscar":
                    this.getComunidades();
                    break;
                case "crear":
                    this.getComunidades();
                    break;
                case "administracion":
                    this.getNoticiasNoApr();
                    this.getcomunidadesNoApr();
                    break;
                default:
                    break;
            }
        },
        //CUENTA DE USUARIO//////////////////////////////////////////////////////////////////////////////////////////////////////
        logout() {////////////////////////////logout//////////////////////
            sessionStorage.removeItem('isLoggedIn');
            sessionStorage.removeItem('username');
            //sessionStorage.removeItem('intereses');
            this.sesion = 0;
            this.currentPage = 'buscar'; 
            this.changePage('buscar');
            //console.log("User has been logged out.");
        },
      
        async UserStatus() {//////////////////////verifica si tienes sesion abierta////////////////////////////////
            this.username = sessionStorage.getItem('username');
            this.interesesUsuario = sessionStorage.getItem('intereses');
            if (this.username) {
                try {
                    //const response = await fetch(`http://localhost:8000/api/usuarios`, {
                    //    method: 'GET',
                    //    headers: {
                    //        'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52',
                    //    }
                    //});
        
                    //if (response.status === 200) { // Check if the request was successful
                    //    const data = await response.json();
                    //    const users = Array.isArray(data.usuarios) ? data.usuarios : [];
                    //    const user = users.find(user => user.nombre === this.username);
                    //    if (user) {
                    //        this.sesion = user.is_admin ? 2 : 1; 
                    //        console.log(this.sesion);
                    //        this.interesesUsuario = user.suscripciones;
                    //    } else {
                    //        this.sesion = 0;
                    //    }
                    //} else {
                    //    // Handle other status codes
                    //    console.error('Error fetching user data:', response.status);
                    //    this.sesion = 0;
                    //}
                } catch (error) {
                    console.error('Error fetching user data:', error);
                    this.sesion = 0;
                }
            } else {
                this.sesion = 2;
            }
        },
        async creaCuenta() {////////////////////crea cuenta/////////////////////////
            let email = this.email;
            let password = this.password;
            let username = this.username;
            let jsonLogin = { "nombre": username, "contrasenya": password, "email": email };
        
            try {
                // Fetch all users
                //const response = await fetch(`http://localhost:8000/api/usuarios`, {
                //    method: 'GET',
                //    headers: {
                //        'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52',
                //        'Content-Type': 'application/json'
                //    }
                //});
        //
                //const data = await response.json();
        //
                //// Check if username or email already exists
                //const userExists = data.usuarios.some(user => user.nombre === username || user.email === email);
        
                //if (!userExists) {
                    // Username and email do not exist, create a new account
                    const createResponse = await fetch(`http://localhost:8000/api/usuarios`, {
                        method: 'POST',
                        headers: {
                            
                            'Content-Type': 'application/json',
                            'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52',
                        },
                        body: JSON.stringify(jsonLogin)
                    });
        
                    if (!createResponse.ok) {
                        throw new Error('Failed to create account');
                    }
        
                    // Account created successfully, handle login
                    sessionStorage.setItem('isLoggedIn', true);
                    sessionStorage.setItem('username', username);
                    sessionStorage.setItem('intereses', "{}");
                    this.sesion = 1;
                    this.changePage('buscar');
        
                //} else {
                //    // Username or email already exists
                //    console.log("El nombre de usuario o el correo electrónico ya existe");
                //}
            } catch (error) {
                console.error('Error:', error);
            }
        },
        async login() {
            let password = this.password;
            let username = this.username;
            try {
                const response = await fetch('http://localhost:8000/api/inicioSesion', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer 2|B6qlWH9Qexp3DIxzIIHeWZ2wGFXUkjxgUPdFDKY79f2a5704'
                    },
                    body: JSON.stringify({ nombre: username, contrasenya: password })
                });
        
                console.log('Response status:', response.status);
        
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
        
                const responseData = await response.json();
                console.log('Response data:', responseData);
        
                if (responseData.status) {
                    sessionStorage.setItem('isLoggedIn', true);
                    sessionStorage.setItem('nombre', username);
                    sessionStorage.setItem('intereses', responseData.user.suscripciones);
                    this.sesion = responseData.user.is_admin ? 2 : 1; 
                    this.interesesUsuario = responseData.user.suscripciones;
                    await this.getNoticiasIntereses();
                    this.changePage('intereses');
                } else {
                    console.log("Invalid username or password.");
                }
            } catch (error) {
                console.error('There has been a problem with your fetch operation:', error);
            }
        },
        //INFO NOTICIAS///////////////////////////////////////////////////////////
        async openNews(noticiaId) {
            
               let enlace= `http://localhost:8000/api/news/${noticiaId}`;
            
            const response = await fetch(enlace, {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52',
                },
            })
            const data = await response.json();
                console.log(data.noticias);
                const comunidadNombre = await this.getComunidadPorID(data.noticias.comunidad_id);
                data.noticias.comunidad_nombre = comunidadNombre;
                this.selectedNews = data.noticias;
                this.currentPage = 'news-details';
        },
        async openNewsNoApr(noticiaId) {
            let enlace= `http://localhost:8000/api/noticiasNoConfirmadas/${noticiaId}`;
            const response = await fetch(enlace, {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52',
                },
            })
            const data = await response.json();
                console.log(data);
                const comunidadNombre = await this.getComunidadPorID(data.noticia.comunidad_id);
                data.noticia.comunidad_nombre = comunidadNombre;
                this.selectedNews = data.noticia;
                this.currentPage = 'news-admin';
        },
        async getNoticiasIntereses() {
            this.noticiasCoinciden=[];
            let noticias=[];
            try {
                let objFiltros = JSON.parse(this.interesesUsuario);
                this.noticiasCoinciden = [];
                for (let i = 0; i < objFiltros.length; i++) {
                    let stringFiltro = `?comunidad_id=${objFiltros[i].comunidad}&veracidad=${objFiltros[i].veracidad}&relevancia=${objFiltros[i].relevancia}`;
                    const apiUrl = 'http://localhost:8000/api/newsFilters';
                    const urlWithParams = `${apiUrl}${stringFiltro}`;
                    const response = await fetch(urlWithParams, {
                        method: 'GET',
                        headers: {
                            'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52',
                        }
                    });
                    const data = await response.json();
                    for (let i = 0; i < data.length; i++) {
                        const comunidadNombre = await this.getComunidadPorID(data[i].comunidad_id);
                        data[i].comunidad_nombre = comunidadNombre;
                        noticias.push(data[i]); 
                    }
                }
                console.log(JSON.stringify( this.noticiasCoinciden));
                noticias.sort((a, b) => a.id - b.id);
                this.noticiasCoinciden= noticias;
                
                console.log("noticias coinciden:", this.noticiasCoinciden); 
            } catch(error) {
                console.error('Error fetching noticias:', error);
            }
        },
        async getNoticiasBusqueda() {
            this.noticiasCoinciden=[];
            let noticias=[];
            const apiUrl = 'http://localhost:8000/api/newsFilters';
            const stringFiltro = `?comunidad_id=${this.comunidadB_ID}&veracidad=${this.veracidadB}&relevancia=${this.relevanciaB}`;
        
            const urlWithParams = `${apiUrl}${stringFiltro}`;
//
            this.comunidadB_N= await this.getComunidadPorID(this.comunidadB_ID);
//
            try {
                const response = await fetch(urlWithParams, {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52',
                    }
                });
                
                const data = await response.json();
                    for (let i = 0; i < data.length; i++) {
                        const comunidadNombre = await this.getComunidadPorID(data[i].comunidad_id);
                        data[i].comunidad_nombre = comunidadNombre;
                        noticias.push(data[i]); 
                    }
                    this.changePage("encontrado");
                    console.log(this.noticiasCoinciden);
                    this.noticiasCoinciden= noticias;
            } catch(error) {
                console.error('Error fetching noticias:', error);
            }
        },
        async getNoticiasNoApr() {
            this.noticiasNoAProbadas=[];
            let noticias=[];
            try {
                const response = await fetch(`http://localhost:8000/api/noticiasNoConfirmadas`, {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52',
                    },
                });
                const data = await response.json();
                for (let i = 0; i < data.noticias.length; i++) {
                    const comunidadNombre = await this.getComunidadPorID(data.noticias[i].comunidad_id);
                    data.noticias[i].comunidad_nombre = comunidadNombre;
                    noticias.push(data.noticias[i]); 
                }
                console.log(data);
                this.noticiasNoAProbadas= noticias;
            } catch(error) {
                console.error('Error fetching noticias:', error);
            }
        },
        async getcomunidadesNoApr() {
            this.comunidadesNoApro=[];
            let comunidades=[];
            try {
                const response = await fetch(`http://localhost:8000/api/comunidadesNoConfirmadas`, {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52',
                    },
                });
                const data = await response.json();
                for (let i = 0; i < data.comunidades.length; i++) {
                    //const comunidadNombre = await this.getComunidadPorID(data.comunidades[i].comunidad_id);
                    //data.comunidades[i].comunidad_nombre = comunidadNombre;
                    comunidades.push(data.comunidades[i]); 
                }
                console.log(data);
                this.comunidadesNoApro= comunidades;
            } catch(error) {
                console.error('Error fetching noticias:', error);
            }
        },
        //AGREGA//////////////////////////////////////////////////////////////////////////////////////////
        agregarNoticia() {
            // Add your fetch code here to add the news article
            fetch('http://localhost:8000/api/noticias', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52'
                },
                body: JSON.stringify(this.nuevaNoticia)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    //alert('Noticia añadida correctamente!');
                    this.nuevaNoticia = {
                        titulo: "",
                        autor: "",
                        url: "",
                        veracidad: -1,
                        relevancia: -1,
                        comunidad_id: -1,
                        fecha_publicacion: "",
                        sinopsis: ""
                    };
                } else {
                    //alert('Error al añadir noticia.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        },
        agregarComunidad() {
            // Add your fetch code here to add the community
            fetch('http://localhost:8000/api/comunidades', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52'
                },
                body: JSON.stringify({"nombre_comunidad":this.nuevaComunidad.nombre_comunidad})
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    //alert('Comunidad añadida correctamente!');
                    this.nuevaComunidad = {
                        nombre_comunidad: "",
                        usuario:"",
                        razon: ""

                    };
                } else {
                    //alert('Error al añadir comunidad.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        },
        //COMUNIDADES//////////////////////////////////////////////////////////////////////////////////////////7
        getComunidades() {
            fetch('http://localhost:8000/api/comunidades', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52',
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.comunidades);
                this.comunidades = data.comunidades;
            })
            .catch(error => {
                console.error('Error fetching comunidades:', error);
            });
        },
        async getComunidadPorID(comunidadId) {
            const apiUrl = `http://localhost:8000/api/comunidades/${comunidadId}`;
            try {
                const response = await fetch(apiUrl, {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52',
                    }
                });
                const data = await response.json();
                //console.log(data)
                return data.comunidad.nombre_comunidad;
            } catch (error) {
                console.error('Error fetching comunidad nombre:', error);
                return '';
            }
        },
    },

   
    mounted() {
       this.UserStatus();
       
       if(this.sesion===0){
           this.currentPage = 'login';
           this.changePage("login")
       }else if(this.sesion > 0){
           this.currentPage = 'intereses';
           this.changePage("intereses")
       }
        //this.sesion=1;
        //this.getNoticiasIntereses();
    }
});



/*modificaNoticia(){
    fetch(`http://localhost:8000/api/news/${this.nuevaNoticia.id}`, {
    method: 'PATCH',
    headers: {
        //'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52',
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(this.nuevaNoticia)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Noticia modificada:', data);
        this.nuevaNoticia = {
          titulo: "",
          autor: "",
          url: "",
          veracidad: -1,
          relevancia: -1,
          comunidad: "",
          fecha_publicacion: "",
          sinopsis: ""
        };
        this.currentPage = "intereses";
        this.changePage("intereses");
    })
    .catch(error => {
        console.error('Error al modificar la noticia:', error);
    });
}*/

/*getNews(){
    fetch('http://localhost:8000/api/news', {
    method: 'GET',
    headers: {
        'Authorization': 'Bearer 1|L6gXGwCweLmBjjFj7ZgG5y5oPPsPX5ihBEqt5Wl24da8ff52',
    }
    })
    .then(response => response.json())
    .then(data => {
        //console.log(this.noticias);
        this.noticias = data.noticias;
        //console.log(this.noticias);
        this.noticias.forEach(noticia => {

            switch (noticia.veracidad) {
                case 1:
                    noticia.veracidad = "Baja";break;
                case 2:
                    noticia.veracidad = "Media";break;
                case 3:
                    noticia.veracidad = "Alta";break;
                case 4:
                    noticia.veracidad = "Confirmada";break;
                default:
                    noticia.veracidad = "";break;
            };

            switch (noticia.relevancia) {
                case 1:
                    noticia.relevancia = "Baja";break;
                case 2:
                    noticia.relevancia = "Media";break;
                case 3:
                    noticia.relevancia = "Alta";break;
                case 4:
                    noticia.relevancia = "Imprescindible";break;
                default:
                    noticia.relevancia = "";break;
            };
            //console.log(this.noticias);
        });
    })
    .catch(error => {
        console.error('Error fetching libros:', error);
    });      
},*/