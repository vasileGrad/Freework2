
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
    conID: '',
    friend_id: '',
    seen: false,
    newMsgFrom: '',
    conProposal: '',
    userFirstName: '',
    userLastName: '',
    firstNameShow: '',
    lastNameShow: '',
    substrJobTitle: '',
    currentProposalStatus: '',
    jobTitle: '',
    jobId: '',
    reviewClient: '',
    rateClient: '',
    reviewFreelancer: '',
    rateFreelancer: '',
    valueTip: '',
    customTip: ''
},

ready: function(){
  this.created();
  //this.listen();
},

/*mounted() {
  this.listen();
},*/

created(){
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
    axios.get('getMessagesId/' + id)
          .then(response => {
            console.log(response.data); // show if success
            app.singleMsgs = response.data; //we are putting data into our posts array
            app.conID = response.data[0].conversation_id;
            app.userFirstName = response.data[0].firstName;
            app.userLastName = response.data[0].lastName;
            app.firstNameShow = response.data[0].firstNameShow;
            app.lastNameShow = response.data[0].lastNameShow;
            //app.substrJobTitle = response.data[0].substrJobTitle;
            app.currentProposalStatus = response.data[0].currentProposalStatus;
            app.jobTitle = response.data[0].jobTitle;
            app.jobId = response.data[0].jobId;
            app.conProposal = response.data[0].conProposal;
            if(response.data[0].reviewClient != null){
              app.reviewClient = response.data[0].reviewClient;
            }
            if(response.data[0].rateClient != null){
              app.rateClient = response.data[0].rateClient;
            }
            if(response.data[0].reviewFreelancer != null){
              app.reviewFreelancer = response.data[0].reviewFreelancer;
              //alert(app.reviewFreelancer);
            }
            if(response.data[0].rateFreelancer != null){
              app.rateFreelancer = response.data[0].rateFreelancer;
              //alert(app.rateFreelancer);
            }
            //alert(response.data[0].reviewClient);
            //alert(response.data[0].rateClient);
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

  sendMsg() {
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
            app.singleMsgs = response.data; //we are putting data into our posts array
            app.conID = response.data[0].conversation_id;
            app.userFirstName = response.data[0].firstName;
            app.userLastName = response.data[0].lastName;
            app.firstNameShow = response.data[0].firstNameShow;
            app.lastNameShow = response.data[0].lastNameShow;
            //app.substrJobTitle = response.data[0].substrJobTitle;
            app.currentProposalStatus = response.data[0].currentProposalStatus;
            app.jobTitle = response.data[0].jobTitle;
            app.jobId = response.data[0].jobId;
            app.conProposal = response.data[0].conProposal;
          }
        })
        .catch(function (error) {
          console.log(error); // run if we have error
        });
        this.msgFrom = "";
      }
    },

  /*listen() {
      //Echo.private('conversation.'+this.conversation_id)
      Echo.private('conversation.'+app.conID)
        .listen('NewMessageEvent', (message) => {
          console.log(message);
          app.singleMsgs = message.data;
          app.conID = message[0].conversation_id;
        })
  },*/

  friendID: function(id){
    app.friend_id = id;
    console.log(app.friend_id);
  },

  sendNewMsg(){
    axios.post('sendNewMessage', {
            friend_id: this.friend_id,
            msg: this.newMsgFrom
          })
          .then(function (response) {
            console.log(response.data); // show if success
            if(response.status===200){
              window.location.replace('messages');
              app.msg = 'your message has been sent successfully';
              this.messages();
            }
          })
          .catch(function (error) {
            console.log(error); // run if we have error
          });
  }, 
   
  startContract(){
    axios.post('startContract', {
        conID: this.conID,
        conProposal: this.conProposal
      })
      .then(function (response) {              
        console.log(response.data); // show if success
        // Refresh the page if success
        if(response.status===200){
          app.singleMsgs = response.data; 
          app.conID = response.data[0].conversation_id;
          app.userFirstName = response.data[0].firstName;
          app.userLastName = response.data[0].lastName;
          app.firstNameShow = response.data[0].firstNameShow;
          app.lastNameShow = response.data[0].lastNameShow;
          //app.substrJobTitle = response.data[0].substrJobTitle;
          app.currentProposalStatus = response.data[0].currentProposalStatus;
          app.jobTitle = response.data[0].jobTitle;
          app.jobId = response.data[0].jobId;
          app.conProposal = response.data[0].conProposal;
        }
      })
      .catch(function (error) {
        console.log(error); // run if we have error
      });
    this.msgFrom = "";
  },

  finishContract(){
    axios.post('finishContract', {
        conID: this.conID,
        conProposal: this.conProposal
      })
      .then(function (response) {              
        console.log(response.data); // show if success
        // Refresh the page if success
        if(response.status===200){
          app.singleMsgs = response.data; 
          app.conID = response.data[0].conversation_id;
          app.userFirstName = response.data[0].firstName;
          app.userLastName = response.data[0].lastName;
          app.firstNameShow = response.data[0].firstNameShow;
          app.lastNameShow = response.data[0].lastNameShow;
          //app.substrJobTitle = response.data[0].substrJobTitle;
          app.currentProposalStatus = response.data[0].currentProposalStatus;
          app.jobTitle = response.data[0].jobTitle;
          app.jobId = response.data[0].jobId;
          app.conProposal = response.data[0].conProposal;
        }
      })
      .catch(function (error) {
        console.log(error); // run if we have error
      });
    this.msgFrom = "";
  },
  
  leaveReviewClient: function(){
    axios.post('leaveReviewClient', {
        conID: this.conID,
        conProposal: this.conProposal,
        rateClient: this.rateClient,
        reviewClient: this.reviewClient
      })
      .then(function (response) {              
        console.log(response.data);
        if(response.status===200){
          app.singleMsgs = response.data; 
          app.conID = response.data[0].conversation_id;
          app.userFirstName = response.data[0].firstName;
          app.userLastName = response.data[0].lastName;
          app.firstNameShow = response.data[0].firstNameShow;
          app.lastNameShow = response.data[0].lastNameShow;
          //app.substrJobTitle = response.data[0].substrJobTitle;
          app.currentProposalStatus = response.data[0].currentProposalStatus;
          app.jobTitle = response.data[0].jobTitle;
          app.jobId = response.data[0].jobId;
          app.conProposal = response.data[0].conProposal;
          app.reviewClient = response.data[0].reviewClient;
          app.rateClient = response.data[0].rateClient;
        }
      })
      .catch(function (error) {
        console.log(error); // run if we have error
      });
  },

  leaveReviewFreelancer: function(){
      axios.post('leaveReviewFreelancer', {
          conID: this.conID,
          conProposal: this.conProposal,
          reviewFreelancer: this.reviewFreelancer,
          rateFreelancer: this.rateFreelancer
          //alert(reviewFreelancer);
          //alert(rateFreelancer);
        })
        .then(function (response) {              
          console.log(response.data);
          if(response.status===200){
            app.singleMsgs = response.data; 
            app.conID = response.data[0].conversation_id;
            app.userFirstName = response.data[0].firstName;
            app.userLastName = response.data[0].lastName;
            app.firstNameShow = response.data[0].firstNameShow;
            app.lastNameShow = response.data[0].lastNameShow;
            //app.substrJobTitle = response.data[0].substrJobTitle;
            app.currentProposalStatus = response.data[0].currentProposalStatus;
            app.jobTitle = response.data[0].jobTitle;
            app.jobId = response.data[0].jobId;
            app.conProposal = response.data[0].conProposal;
            app.reviewClient = response.data[0].reviewClient;
            app.rateClient = response.data[0].rateClient;
            app.reviewFreelancer = response.data[0].reviewFreelancer;
            app.rateFreelancer = response.data[0].rateFreelancer; 
          }
        })
        .catch(function (error) {
          console.log(error); // run if we have error
        });
  },

  leaveTip: function() {
    axios.post('leaveTip', {
          conID: this.conID,
          conProposal: this.conProposal,
          valueTip: this.valueTip,
          customTip: this.customTip
        })
        .then(function (response) {  
          //console.log(response.data);
          if(response.status===200){
            app.singleMsgs = response.data; 
            app.conID = response.data[0].conversation_id;
            app.userFirstName = response.data[0].firstName;
            alert(app.userFirstName);
            app.userLastName = response.data[0].lastName;
            alert(app.userLastName);
            app.firstNameShow = response.data[0].firstNameShow;
            app.lastNameShow = response.data[0].lastNameShow;
            //app.substrJobTitle = response.data[0].substrJobTitle;
            app.currentProposalStatus = response.data[0].currentProposalStatus;
            alert(app.currentProposalStatus);
            app.jobTitle = response.data[0].jobTitle;
            app.jobId = response.data[0].jobId;
            app.conProposal = response.data[0].conProposal;
            if(response.data[0].reviewClient != null){
              app.reviewClient = response.data[0].reviewClient;
            }
            if(response.data[0].rateClient != null){
              app.rateClient = response.data[0].rateClient;
            }
            if(response.data[0].reviewFreelancer != null){
              app.reviewFreelancer = response.data[0].reviewFreelancer;
              //alert(app.reviewFreelancer);
            }
            if(response.data[0].rateFreelancer != null){
              app.rateFreelancer = response.data[0].rateFreelancer;
              //alert(app.rateFreelancer);
            } 
          }
        })
        .catch(function (error) {
          console.log(error); // run if we have error
        });
        this.customTip = "";
        this.valueTip = "";
  }
}
});
