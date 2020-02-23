<template>
	<view class="page">
		<swiper :indicator-dots="true" :autoplay="true" :interval="3000" :duration="1000">
			<!-- <swiper-item>
				<image src="../../static/carousel/batmanvssuperman.png" mode="" class="carousel"></image>
			</swiper-item>
			<swiper-item>
				<image src="../../static/carousel/spiderman.png" mode=""></image>
			</swiper-item> -->
			<swiper-item v-for="(carousel,index) in carouselList" :key="index">
				<image :src="carousel.image" mode="" class="carousel"></image>
			</swiper-item>
		</swiper>
		
		<view class="page-block super-hot">
			<view class="hot-title-wapper">
				<image src="../../static/icos/hot.png" mode="" class="hot-ico"></image>
				<view class="hot-title">
					热门
				</view>
			</view>
		</view>
		
		<scroll-view scroll-x="true" class="page-block hot">
			<view class="single-poster" v-for="(superhero,index) in hotSuperheroList" :key="index">
				<view class="poster-wapper">
					<image :src="superhero.cover" mode="" class="poster"></image>
					<view class="movie-name">
						{{superhero.name}}
					</view>
					<trailerStars :innerScore="superhero.score" showNum="1"></trailerStars>
				</view>
			</view>
		</scroll-view>
		
		<view class="page-block super-hot">
			<view class="hot-title-wapper">
				<image src="../../static/icos/interest.png" mode="" class="hot-ico"></image>
				<view class="hot-title">
					热门预告
				</view>
			</view>
		</view>
		
		<view class="hot-movies page-block">
			<video 
				:id="trailer.id"
				:data-playingIndex="trailer.id"
				@play="meIsPlaying"
				:src="trailer.trailer" controls v-for="(trailer,index) in hotTrailerList" :key="index" :poster="trailer.poster" class="hot-movie-single"></video>
		</view>
		
		<view class="page-block super-hot">
			<view class="hot-title-wapper">
				<image src="../../static/icos/guess-u-like.png" mode="" class="hot-ico"></image>
				<view class="hot-title">
					猜你喜欢
				</view>
			</view>
		</view>
		
		<view class="page-block guess-u-like">
			<view class="single-like-movie" v-for="(guess,gIndex) in guessULikeList" :key="gIndex">
				<image :src="guess.cover" mode="" class="like-movie"></image>
				<view class="movie-desc">
					<view class="movie-title">{{guess.name}}</view>
					<trailerStars :innerScore="9.1" showNum="0"></trailerStars>
					<view class="movie-info">{{guess.basicInfo}}</view>
					<view class="movie-info">{{guess.releaseDate}}</view>
				</view>
				<view class="movie-oper" @click="praseMe" :data-gIndex="gIndex">
					<image src="../../static/icos/praise.png" mode="" class="praise-ico"></image>
					<view class="praise-me">
						点赞
					</view>
					<view :animation="animationDataArr[gIndex]" class="praise-me animation-opacity">
						+1
					</view>
				</view>
			</view>
		</view>
		
	</view>
</template>

<script>
	import common from "../../common/common.js"
	import trailerStars from "../../components/trailerStars.vue"
	export default {
		components:{trailerStars},
		data() {
			return {
				carouselList: [],
				hotSuperheroList:[],
				hotTrailerList:[],
				guessULikeList:[],
				animationData:{},
				animationDataArr:[{},{},{},{},{}],
			}
		},
		onLoad() {
			this.animation=uni.createAnimation();
			
			
			//var _this=this;
			var serverUrl=common.serverUrl;
			//请求轮播图数据
			uni.request({
			    url: serverUrl+'/index/carousel', 
			    method:"GET",
				success: (res) => {//箭头函数不需要_this
			        //console.log(res.data);
					if(res.data.code==200){
						var carouselList=res.data.data;
						this.carouselList=carouselList;
					}
			    }
			});
			
			//查询热门
			uni.request({
			    url: serverUrl+'/index/hot', 
			    method:"GET",
				success: (res) => {//箭头函数不需要_this
			        //console.log(res.data);
					if(res.data.code==200){
						var hotSuperheroList=res.data.data;
						this.hotSuperheroList=hotSuperheroList;
					}
			    }
			});
			//查询热门 预告
			uni.request({
			    url: serverUrl+'/index/hot', 
			    method:"GET",
				data:{type:'trailer'},
				success: (res) => {//箭头函数不需要_this
			        //console.log(res.data);
					if(res.data.code==200){
						var hotTrailerList=res.data.data;
						this.hotTrailerList=hotTrailerList;
					}
			    }
			});
			
			this.refresh();
			
		},
		onUnload() {
			this.animationData={};
			this.animationDataArr=[{},{},{},{},{}];
		},
		onPullDownRefresh() {
			this.refresh();
		},
		onHide() {
			if(this.videoContext){
				this.videoContext.pause();
			}
		},
		methods: {
			refresh(){
				uni.showLoading({
					mask:true
				})
				
				var serverUrl=common.serverUrl;
				//查询猜你喜欢
				uni.request({
				    url: serverUrl+'/index/guess-u-like', 
				    method:"GET",
					success: (res) => {//箭头函数不需要_this
				        //console.log(res.data);
						if(res.data.code==200){
							var guessULikeList=res.data.data;
							this.guessULikeList=guessULikeList;
						}
				    },
					complete:() => {
						uni.hideLoading();
				    	uni.stopPullDownRefresh();
				    }
				});
			},
			praseMe(e){				
				var gIndex = e.currentTarget.dataset.gindex;
				console.log(gIndex);
				
				this.animation.translateY(-60).opacity(1).step({duration:400})
				this.animationData = this.animation;
				this.$set(this.animationDataArr,gIndex,this.animationData.export());
				setTimeout(function() {
					this.animation.translateY(0).opacity(0).step({duration:0});
					this.animationData=this.animation;
					this.$set(this.animationDataArr,gIndex,this.animationData.export());
				}.bind(this), 500);
				
				console.log(this.animationDataArr)
			},
			meIsPlaying(e){//播放时，暂停其他视频
				var trailerId="";
				if(e){
					trailerId=e.currentTarget.dataset.playingindex
					this.videoContext=uni.createVideoContext(trailerId)
				}
				var hotTrailerList=this.hotTrailerList;
				for(var i in hotTrailerList){
					var tempId=hotTrailerList[i].id;
					if(tempId!=trailerId){
						uni.createVideoContext(tempId).pause()
					}
				}
			}
		}
	}
</script>

<style>
	@import url("index.css");
</style>
