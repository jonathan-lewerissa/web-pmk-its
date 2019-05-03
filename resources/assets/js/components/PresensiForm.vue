<template>
    <div class="container">
        <div>
            <h1 id="title">
                <b v-if="this.event_details.type === 'PU' || this.event_details.type === 'PM'">Persekutuan Jumat</b>
                <b v-else>Persekutuan Jumat</b>
            </h1>
        </div>
        <div class="login-box">
            <div class="box-header">
                <h2>Attendance</h2>
            </div>
            <form action="" @submit.prevent="sendPresensi">
                <h3><b><i>{{ this.event_details.description }}</i></b></h3>
                <h4><b>{{ this.starting }}</b></h4>
                <div id="txt">{{ this.clock }}</div>
                <div v-if="this.event_details.type === 'PJ'">
                    <h4><i>Total:</i></h4>
                    <h3>{{ count }}</h3>
                </div>
                <div v-if="this.event_details.type === 'PU'">
                    <input required type="text" name="nama" placeholder="Your name" v-model='nama'>
                    <br>
                    <input required type="text" placeholder="Where are you from?" v-model='asal'>
                    <br>
                    <input required type="tel" placeholder="Your phone number" v-model='telp'>
                </div>
                <div v-else-if="this.event_details.type === 'PM'">
                    <input required type="text" name="nrp" minlength="14" maxlength="14" placeholder="NRP Baru" v-model='nrp'>
                    <br>
                    <input required type="text" name="nama" placeholder="Nama Lengkap" v-model="nama">
                </div>
                <div v-else>
                    <input type="text" name="nrp" minlength="14" maxlength="14" placeholder="NRP Baru" v-model='nrp'>
                </div>
                <button type="submit">Submit</button>
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
                nama: '',
                asal: '',
                telp: '',
            }
        },
        methods: {
            sendPresensi: function() {
                axios
                .post('/api/presensi',{
                    event_token: this.event_token,
                    nrp: this.nrp,
                    nama: this.nama,
                    asal: this.asal,
                    telp: this.telp,
                })
                .then(res => {
                    this.count = res.data.count;
                    let textToDisplay = '';
                    if(this.event_details.type === 'PU' || this.event_details.type === 'PM') {
                        textToDisplay = 'Hi '+this.nama+'! Have a wonderful day with Jesus!'
                    }
                    else {
                        textToDisplay = 'Hi! Have a wonderful day with Jesus!'
                    }
                    Swal.fire({
                        type: 'success',
                        title: 'Success!',
                        text: textToDisplay,
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
                    this.nrp = '';
                    this.nama = '';
                    this.asal = '';
                    this.telp = '';
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
