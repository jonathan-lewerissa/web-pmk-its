<template>
    <div class="container">
        <div>
            <h1 id="title"><b>{{ this.event_details.title }}</b></h1>
        </div>
        <div class="login-box">
            <div class="box-header">
                <h2>Attendance</h2>
            </div>
            <form action="" @submit.prevent="sendPresensi">
                <h3><b><i>{{ this.event_details.description }}</i></b></h3>
                <h4><b>{{ this.starting }}</b></h4>
                <div id="txt">{{ this.clock }}</div>
                <h4><i>Total:</i></h4>
                <h3>{{ count }}</h3>
                <input type="text" name="nrp" minlength="14" maxlength="14" placeholder="NRP Baru" v-model='nrp'>
            </form>
            <br>
            <h5><i>Copyright&copy; PMK ITS <b>2019</b></i></h5>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['counter','event_details'],
        data() {
            return {
                nrp: '',
                count: this.counter,
                event_token: this.event_details.event_url,
                clock: moment().format('LTS'),
                starting: moment(this.event_details.event_start).format("dddd, MMMM Do YYYY"),
            }
        },
        methods: {
            sendPresensi: function() {
                axios
                .post('/api/presensi',{
                    event_token: this.event_token,
                    nrp: this.nrp,
                })
                .then(res => {
                    this.count = res.data.count;
                    Swal.fire({
                        type: 'success',
                        title: 'Success!',
                        text: 'Hi! Have a wonderful day with Jesus!',
                        timer: 3000
                    })
                })
                .catch(err => {
                    if(err.response.status === 500){
                        if(err.response.data.errorInfo[1] === 1062)
                        Swal.fire({
                            type: 'error',
                            title: 'Oopsie!',
                            text: 'You have been recorded before!',
                            timer: 3000
                        })
                    } 
                    else {
                        console.error(err.response);
                    }
                })
                .then(()=>{
                    this.nrp = ''
                })
            }
        },
        mounted: function() {
            setInterval(() => {
                this.clock = moment().format('LTS')
            }, 1000);
        }
    }
</script>
