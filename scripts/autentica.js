var firebaseConfig = {
        
    apiKey: "AIzaSyCoI85ljqSBIU-3yX_Qo9DWRNjYmc610nE",
    authDomain: "cemeja-ibnyjp.firebaseapp.com",
    projectId: "cemeja-ibnyjp",
    storageBucket: "cemeja-ibnyjp.appspot.com",
    messagingSenderId: "89076796497",
    appId: "1:89076796497:web:808ca67192c70b0a557c70"

};


// Inicialize o Firebase
firebase.initializeApp(firebaseConfig);

function login() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    firebase.auth().signInWithEmailAndPassword(email, password)
        .then(function(userCredential) {
            // Autenticação bem-sucedida
            var user = userCredential.user;
            console.log('Usuário autenticado:', user);

            // Ler dados do Firestore após autenticação
            var db = firebase.firestore();
            var usersCollection = db.collection("cad_usuarios");

            // Consultar documentos onde a coluna 'ID' corresponde ao UID do usuário autenticado
            usersCollection.where("id_usuario", "==", user.uid).get()
                .then(function(querySnapshot) {
                    if (!querySnapshot.empty) {
                        // Documento encontrado, verificar o nível
                        var doc = querySnapshot.docs[0]; // Assume que há apenas um documento correspondente

                        var nivel = doc.data().nivel;
                        console.log('Nível do usuário:', nivel);

                        // Redirecionar com base no nível
                        if (nivel === "Administrador") {
                            window.location.href = "admin/painel_administrador.html";
                        } else if (nivel === "Professor") {
                            window.location.href = "admin/painel_professor.html";
                        } else {
                            console.error('Nível desconhecido:', nivel);
                        }
                    } else {
                        console.error('Documento não encontrado para o usuário:', user.uid);
                    }
                })
                .catch(function(error) {
                    console.error('Erro ao obter dados do Firestore:', error);
                });
        })
        .catch(function(error) {
            // Lidar com erros de autenticação
            var errorCode = error.code;
            var errorMessage = error.message;
            console.error('Erro na autenticação:', errorMessage);
        });
}