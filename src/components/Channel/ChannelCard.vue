<template>
  <div v-if="videos && videos.length > 0" class="channel">
    <div class="title-card">
      <ChannelInfo :channel="channel" />
    </div>

    <VideoList :videos="videos" />
  </div>
</template>

<script>
import ChannelInfo from './ChannelInfo';
import VideoList from '../Video/VideoList';
//import VideoCard from '../Video/VideoCard';

export default {
  inject: [], // 'channels',
  props: ['channel'],
  components: {
    ChannelInfo,
    VideoList
    //VideoCard
  },
  data() {
    return {
      videos: [],
      videoPage: 1,
      videosLoading: false,
      xDown: false,
      yDown: false,
      sliderSize: 340,
      moveLeft: false,
      moveRight: false,
      translate: 0,
      moveTranslate: 0,
      width: 6800,
      maxWidth: 6800,
      $videoWrap: null
    };
  },
  created() {
    //this.loadVideos();
    //console.log(this.channel);
    this.videos = this.channel.videos;
    this.width = this.videos ? this.videos.length * this.sliderSize : 0;
  },
  methods: {
    loadVideos() {
      //var limit = 10;

      this.videosLoading = true;

      fetch(
        process.env.VUE_APP_URL +
          'channel/videoList.php?channel_id=' +
          this.channel.channel_id +
          '&offset=' +
          this.videoPage,
        {
          //mode: 'no-cors',
          method: 'GET',
          headers: { 'Content-Type': 'application/json' }
        }
      )
        .then(response => {
          if (response.ok) {
            this.videoPage++;
            return response.json();
          }
        })
        .then(data => {
          this.videosLoading = false;

          this.videos = this.videos.concat(data);
        })
        .catch(error => {
          //this.errorMessage = error;
          this.videosLoading = false;
          console.error('There was an error!', error);
        });
    }
  }
};
</script>

<style>
.channel {
  /* border-bottom: 1px solid #f7f7f9; */
  padding-bottom: 20px;
  margin-bottom: 20px;
  transition: border-color 0.2s;
}

.title-card {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
</style>
