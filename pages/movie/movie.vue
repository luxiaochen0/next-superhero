<template>
	<view class="page">
		<view class="player">
			<video :src="trailerInfo.trailer" :poster="trailerInfo.poster" class="movie" controls></video>
		</view>
		
		<view class="movie-info">
			<image :src="trailerInfo.cover" model="" class="cover"></image>
			<view class="movie-desc">
				<view class="title">{{trailerInfo.name}}</view>
				<view class="basic-info">{{trailerInfo.basicInfo}}</view>
				<view class="basic-info">{{trailerInfo.originalName}}</view>
				<view class="basic-info">{{trailerInfo.totalTime}}</view>
				<view class="basic-info">{{trailerInfo.releaseDate}}</view>
				<view class="score-block">
					<view class="big-score">
						<view class="score-words">综合评分:</view>
						<view class="movie-score">{{trailerInfo.score}}</view>
					</view>
					<view class="score-stars">
						<block v-if="trailerInfo.score>=0">
							<trailerStars :innerScore="trailerInfo.score" showNum="0"></trailerStars>
						</block>						
						<view class="praise-counts">
							{{trailerInfo.prisedCounts}} 人点赞
						</view>
					</view>
				</view>
			</view>
		</view>
		
		<view class="line-wapper">
			<view class="line">
				
			</view>
			
		</view>
		
		<view class="plots-block">
			<view class="plots-title">剧情介绍</view>
			<view class="plots-desc">{{trailerInfo.plotDesc}}</view>
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
				trailerInfo:{},
				plotPicsArray:[],
				directorArray:[],
				actorArray:[]
			}
		},
		onLoad(params) {
			var trailerId=params.trailerId;
			
			uni.showLoading({
				mask:true,
				title:"请稍后"
			})
			
			var serverUrl=common.serverUrl;
			//查询
			uni.request({
			    url: serverUrl+'/search/trailer', 
			    method:"GET",
				data:{id:trailerId},
				success: (res) => {//箭头函数不需要_this
			        //console.log(res.data);
					if(res.data.code==200){
						var trailerInfo=res.data.data;
						this.trailerInfo=trailerInfo;
						
						var plotPicsArray=JSON.parse(trailerInfo.plotPics)
						this.plotPicsArray=plotPicsArray
					}
			    },complete() {
					uni.hideLoading();
			    }
			});
			
			//获取导演
			uni.request({
			    url: serverUrl+'/search/staff', 
			    method:"GET",
				data:{id:trailerId,role:1},
				success: (res) => {//箭头函数不需要_this
			        //console.log(res.data);
					if(res.data.code==200){
						this.directorArray=res.data.data;
					}
			    },complete() {
			    }
			});
			
			//获取演员
			uni.request({
			    url: serverUrl+'/search/staff', 
			    method:"GET",
				data:{id:trailerId,role:2},
				success: (res) => {//箭头函数不需要_this
			        //console.log(res.data);
					if(res.data.code==200){
						this.actorArray=res.data.data;
					}
			    },complete() {
			    }
			});
		},
		methods: {
			
		}
	}
</script>

<style>
@import url("movie.css");
</style>
