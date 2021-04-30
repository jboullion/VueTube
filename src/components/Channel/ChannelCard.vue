<template>
  <div v-if="videos && videos.length > 0" class="channel">
    <div class="d-flex justify-content-between align-items-center">
      <div class="title-card">
        <ChannelInfo :channel="channel" />
      </div>
      <div class="channel-controls">
        <a
          class="channel-control prev"
          @click.prevent="$refs.videoList.moveChannel(false)"
        >
          <i class="fas fa-chevron-left"></i>
        </a>
        <a
          class="channel-control next"
          @click.prevent="$refs.videoList.moveChannel(true)"
        >
          <i class="fas fa-chevron-right"></i>
        </a>
      </div>
    </div>
    <VideoList :videos="videos" ref="videoList" />
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
    // loadVideos() {
    //   //var limit = 10;
    //   this.videosLoading = true;
    //   fetch(
    //     process.env.VUE_APP_URL +
    //       'channel/videoList.php?channel_id=' +
    //       this.channel.channel_id +
    //       '&offset=' +
    //       this.videoPage,
    //     {
    //       //mode: 'no-cors',
    //       method: 'GET',
    //       headers: { 'Content-Type': 'application/json' }
    //     }
    //   )
    //     .then(response => {
    //       if (response.ok) {
    //         this.videoPage++;
    //         return response.json();
    //       }
    //     })
    //     .then(data => {
    //       this.videosLoading = false;
    //       this.videos = this.videos.concat(data);
    //     })
    //     .catch(error => {
    //       //this.errorMessage = error;
    //       this.videosLoading = false;
    //       console.error('There was an error!', error);
    //     });
    // }
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

.channel-controls {
}

.channel-control {
  cursor: pointer;
  display: inline-block;
  padding: 10px;
  margin: 0 10px;
  z-index: 1;
  width: 40px;
  top: 0;
  opacity: 0.5;
  text-align: center;
  transition: transform 0.2s, opacity 0.2s;
}

.channel-control:hover {
  opacity: 1;
  transform: scale(1.5);
}

.channel-control.prev {
  left: 0;
}

.channel-control.next {
  right: 0;
}

.channel-control i {
  font-size: 24px;
  transition: all 0.2s linear;
  color: black;
}

@media (max-width: 768px) {
  .channel-control {
    display: none;
  }
}
</style>
