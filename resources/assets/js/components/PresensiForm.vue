<template>
    <div>
        <h1>{{ this.event_details.title }}</h1>
        <h2>{{ this.event_details.description }}</h2>
        <h2>{{ this.clock }}</h2>
        <h3>{{ this.starting }}</h3>
        <form action="" @submit.prevent="sendPresensi">
            <div class="form-group">
                <input type="text" placeholder="NRP Baru" v-model='nrp'>
            </div>
            <h3>{{ count }}</h3>
        </form>
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
