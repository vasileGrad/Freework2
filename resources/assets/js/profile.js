
require('./bootstrap');

window.Vue = require('vue');

window.VueRouter = require('vue-router').default;

window.VueAxios = require('vue-axios').default;

window.Axios = require('axios').default;

Vue.use(require('moment'));

Vue.use(VueRouter,VueAxios, axios);

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
  el: '#app',
  data: {
    msg: 'New Conversation: ',
    content: '',
    privateMsgs: [],
    singleMsgs: [],
    msgFrom: '',
    conID: ''
    /*,,
    friend_id: '',
    seen: false,
    newMsgFrom: ''
*/
 },

 ready: function(){
   this.created();
 },
 created(){
  //console.log('createdddddd');
   axios.get('getMessages')
        .then(response => {
          console.log(response.data); // show if success
          // privateMsgs comes from web.php - Route::get('/getMessages', function () {
          // and goes up in the privateMsgs array
          app.privateMsgs = response.data; //we are putting data into our posts array
          Vue.filter('myDateTime', function(value){
            return moment(value).calendar();
          });
        })
        .catch(function (error) {
          console.log(error); // run if we have error
        });
 },

 methods:{
   messages: function(id){
     axios.get('getMessages/' + id)
          //alert(id);
          .then(response => {
            console.log(response.data); // show if success
           app.singleMsgs = response.data; //we are putting data into our posts array
           app.conID = response.data[0].conversation_id;
          })
          .catch(function (error) {
            console.log(error); // run if we have error
          });
   },

   inputHandler(e){
    // if Enter key was pressed and not shiftKey (new line)
     if(e.keyCode === 13 && !e.shiftKey){
       e.preventDefault();
       this.sendMsg();
     }
   },

    moment: function () {
      return moment();
    },

   sendMsg(){
     if(this.msgFrom){
      //alert(this.conID);
      //alert(this.msgFrom);
       axios.post('sendMessage', {
          conID: this.conID,
          msg: this.msgFrom
        })
        .then(function (response) {              
          console.log(response.data); // show if success
          // Refresh the page if success
          if(response.status===200){
            app.singleMsgs = response.data;
            app.conID = response.data[0].conversation_id;
          }
        })
        .catch(function (error) {
          console.log(error); // run if we have error
        });
      this.msgFrom = "";
      //setInterval(refreshMessages(this.conID), 1000);
      //this.refreshMessages(this.conID);
     }
   },

  /* friendID: function(id){
     app.friend_id = id;
   },
   sendNewMsg(){
     axios.post('sendNewMessage', {
            friend_id: this.friend_id,
            msg: this.newMsgFrom,
          })
          .then(function (response) {
            console.log(response.data); // show if success
            if(response.status===200){
              window.location.replace('http://localhost/larabook/index.php/messages');
              app.msg = 'your message has been sent successfully';
            }

          })
          .catch(function (error) {
            console.log(error); // run if we have error
          });
   }
*/  

    startContract(){
       axios.post('startContract', {
          conID: this.conID
        })
        .then(function (response) {              
          console.log(response.data); // show if success
          // Refresh the page if success
          if(response.status===200){
            app.singleMsgs = response.data;
            app.conID = response.data[0].conversation_id;
          }
        })
        .catch(function (error) {
          console.log(error); // run if we have error
        });
      this.msgFrom = "";
      },

    finishContract(){
       axios.post('finishContract', {
          conID: this.conID
        })
        .then(function (response) {              
          console.log(response.data); // show if success
          // Refresh the page if success
          if(response.status===200){
            app.singleMsgs = response.data;
            app.conID = response.data[0].conversation_id;
          }
        })
        .catch(function (error) {
          console.log(error); // run if we have error
        });
      this.msgFrom = "";
      }
    }
});
