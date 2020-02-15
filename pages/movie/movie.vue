<template>
	<view class="page">
		<view class="player">
			<video :src="trailerInfo.trailer" :poster="trailerInfo.poster" class="movie" controls></video>
		</view>
		
		<view class="movie-info">
			<navigator :url="'../cover/cover?cover='+trailerInfo.cover">
				<image :src="trailerInfo.cover" model="" class="cover"></image>
			</navigator>
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
		
		<!-- 演职人员 -->
		<view class="sroll-block">
			<view class="plots-title">演职人员</view>
			<scroll-view scroll-x="true" class="scroll-list">
				<view class="actor-wapper" v-for="(director,index) in directorArray" :key="'director'+index">
					<image
						mode="aspectFill" 						
						:src="director.photo" 
						class="single-actor" 
						@click="lookStaffs"
						:data-staffIndex="index"
					></image>
					<view class="actor-name">{{director.name}}</view>
					<view class="actor-role">{{director.actName}}</view>
				</view>
				<view class="actor-wapper" v-for="(actor,index) in actorArray" :key="'actor'+index">
					<image
						mode="aspectFill" 
						:src="actor.photo" 
						class="single-actor" 
						@click="lookStaffs"
						:data-staffIndex="index+directorArray.length"
					></image>
					<view class="actor-name">{{actor.name}}</view>
					<view class="actor-role">{{actor.actName}}</view>
				</view>
			</scroll-view>
		</view>
		
		<!-- 剧照 -->
		<view class="sroll-block">
			<view class="plots-title">剧照</view>
			<scroll-view scroll-x="true" class="scroll-list">
				<image 
					mode="aspectFill" 
					v-for="(img,index) in plotPicsArray" 
					:key="index"
					:src="img" 
					class="plot-image" 
					@click="lookMe"
					:data-imgIndex="index"
				></image>
			</scroll-view>
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
			uni.setNavigationBarColor({
				frontColor:"#ffffff",
				backgroundColor:"#000000"
			})
			
			
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
		//仅支持小程序端
		onShareAppMessage(res) {
			return {
				title: this.trailerInfo.name,
				path:'/pages/movie/movie?trailerId='+this.trailerInfo.id
			}
		},
		methods: {
			lookMe(e){
				var imgIndex=e.currentTarget.dataset.imgindex;
				uni.previewImage({
					urls:this.plotPicsArray,
					current:this.plotPicsArray[imgIndex]
				})
			},
			lookStaffs(e){
				var staffIndex=e.currentTarget.dataset.staffindex;
				
				var newStaffArray=this.directorArray.concat(this.actorArray)
				var urls=[];
				for(var i in newStaffArray){
					var temp=newStaffArray[i].photo;
					urls.push(temp)
				}
				
				uni.previewImage({
					urls:urls,
					current:urls[staffIndex]
				})
			}
		}
	}
</script>

<style>
@import url("movie.css");
</style>
