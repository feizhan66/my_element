<template>
  <div class="app-container">
    <el-form ref="form" :rules="createShopRules" :model="createShopForm" label-width="100px">
      <el-form-item prop="name" label="门店名称">
        <el-col :span="12">
          <el-input v-model="createShopForm.name"></el-input>
        </el-col>  
      </el-form-item>
      <el-form-item prop="telephone" label="联系电话">
        <el-col :span="12">
          <el-input v-model="createShopForm.telephone"></el-input>
        </el-col>
      </el-form-item>
      <el-form-item prop="qq" label="联系QQ">
        <el-col :span="12">
          <el-input v-model="createShopForm.qq"></el-input>
        </el-col>
      </el-form-item>
      <el-form-item label="所属行业">
        <el-col :span="12">
          <el-select v-model="createShopForm.businessTypeDefault" placeholder="请选择">
            <el-option
              v-for="item in createShopForm.businessType"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-col>  
      </el-form-item>
      <el-form-item label="上传图片">
        <el-upload
          action="https://jsonplaceholder.typicode.com/posts/"
          list-type="picture-card"
          :on-preview="handlePictureCardPreview"
          :on-remove="handleRemove">
          <i class="el-icon-plus"></i>
        </el-upload>
        <el-dialog :visible.sync="dialogVisible">
          <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>
      </el-form-item>
      <el-form-item label="所在地区">
        <el-cascader
          ref="currentPosition"
          :options="district"
          @click="_getDistrict"
          @active-item-change="handleItemChange"
          @change="handlePositionChange"
          :props="props"
        ></el-cascader>
      </el-form-item>
      <el-form-item prop="location" label="详细地址">
        <el-col :span="12" class="none-start-gutter">
          <el-input v-model="createShopForm.location" @input="handleUserInputAddress"></el-input>
        </el-col>
      </el-form-item>
      <el-form-item label="经纬度坐标">
        <el-row :gutter="20">
          <el-col :span="12" class="none-start-gutter">
            <el-input :disabled="true" v-model="createShopForm.longitudeAndLatitude"></el-input>
          </el-col>
          <el-col :span="2">
            <el-button type="primary" @click="getCoordinateByAddress">查询坐标</el-button>
          </el-col>
        </el-row>
        <el-row>
          <el-col>
            {{createShopForm.address}}
          </el-col>
        </el-row>
      </el-form-item>
      <el-form-item label="高德地图">
        <div id="container" class="mymap"></div>
      </el-form-item>
      <el-form-item prop="detail" label="商家介绍">
        <el-col :span="12">
          <el-input type="textarea" :rows=6 placeholder="请输入商家介绍" v-model="createShopForm.detail"></el-input>
        </el-col>
      </el-form-item>
      <el-form-item>
        <el-radio v-model="createShopForm.radio" label="1">开启</el-radio>
        <el-radio v-model="createShopForm.radio" label="2">关闭</el-radio>
      </el-form-item>
      <el-form-item label="店铺链接">
        <el-col :span="12">        
          <a href="">http:localhost/index</a>
        </el-col>
      </el-form-item>
      <el-form-item>
        <el-button @click="onSubmit" type="primary">保存</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { Message } from 'element-ui'
import AMap from 'AMap'
import { getDistrict } from '@/api/district'

let map

export default {
  name: 'createshop',
  data() {
    const validateName = (rule, value, callback) => {
      if (value.length < 1) {
        callback(new Error('请输入不少于两位的门店名称'))
      } else {
        callback()
      }
    }
    const validateQQ = (rule, value, callback) => {
      if (value.length <= 6) {
        callback(new Error('请输入正确的QQ号码'))
      } else {
        callback()
      }
    }
    const validateTelephone = (rule, value, callback) => {
      if (value.length !== 11) {
        callback(new Error('请输入正确的手机号码'))
      } else {
        callback()
      }
    }
    // const validateBusiness = (rule, value, callback) => {
    //   if (value) {
    //     callback(new Error('请选择服务行业'))
    //   } else {
    //     callback()
    //   }
    // }
    const validateLocation = (rule, value, callback) => {
      if (value.length < 2) {
        callback(new Error('详细地址不得少于两个字'))
      } else {
        callback()
      }
    }
    const validateDetail = (rule, value, callback) => {
      if (value.length !== 11) {
        callback(new Error('门店介绍不得少于10个字'))
      } else {
        callback()
      }
    }
    return {
      // 设置地区的字段
      props: {
        value: 'id',
        label: 'name',
        children: 'children'
      },
      district: [],
      createShopForm: {
        name: '',
        telephone: '',
        qq: '',
        businessTypeDefault: '',
        location: '',
        detail: '',
        longitude: '',
        latitude: '',
        businessType: [
          {
            value: 'shenghuo',
            label: '生活服务'
          },
          {
            value: 'meirongmeifa',
            label: '美容美发'
          },
          {
            value: 'shougongzhizuo',
            label: '手工制作'
          }
        ],
        region: '',
        longitudeAndLatitude: '',
        proCityDist: '',
        address: '',
        radio: '1'
      },
      createShopRules: {
        name: [{ required: true, trigger: 'blur', validator: validateName }],
        qq: [{ required: true, trigger: 'blur', validator: validateQQ }],
        telephone: [{ required: true, trigger: 'blur', validator: validateTelephone }],
        location: [{ required: false, trigger: 'blur', validator: validateLocation }],
        detail: [{ required: false, trigger: 'blur', validator: validateDetail }]
      },
      dialogImageUrl: '',
      dialogVisible: false,

      region_id: 1,
      getDistrictCount: 0 // 第几次请求地址名称
    }
  },
  created() {
    this._getDistrict()
  },
  mounted() {
    this.loadmap()
  },
  methods: {
    // 获取省市区
    _getDistrict() {
      const params = {}
      Object.assign(params, {
        sub_district: 1,
        region_id: this.region_id
      })
      getDistrict(params).then((res) => {
        console.log('请求')
        const children = res.data[0].children
        if (this.getDistrictCount < 2) {
          children.forEach((item, index) => {
            item.children = []
          })
        }
        if (this.getDistrictCount === 1) {
          this.district.forEach((item) => {
            if (item.id === this.region_id) {
              item.children = children
            }
          })
          return
        }
        if (this.getDistrictCount === 2) {
          this.district.forEach((item) => {
            if (item.id === this.lastRegionId) {
              item.children.forEach((lastItem) => {
                lastItem.children = children
                return
              })
            }
          })
          return
        }
        this.district = children
      }, (error) => {
        console.log(error)
      })
    },
    loadmap() {
      const self = this
      AMapUI.loadUI(['misc/PositionPicker'], function(PositionPicker) {
        map = new AMap.Map('container', {
          zoom: 15,
          scrollWheel: true,
          resizeEnable: true
        })
        var positionPicker = new PositionPicker({
          mode: 'dragMap',
          map: map
        })
        // 加载成功
        positionPicker.on('success', positionResult => {
          self.createShopForm.longitude = positionResult.position.lng
          self.createShopForm.latitude = positionResult.position.lat
          self.createShopForm.longitudeAndLatitude = positionResult.position.lng + ' , ' + positionResult.position.lat
          self.createShopForm.address = positionResult.address
        })
        // 加载失败
        positionPicker.on('fail', function(positionResult) {
          Message.error({ message: '目前只能选择国内的地址' })
        })
        // 开始加载
        positionPicker.start()
      })
    },
    onSubmit() {
      console.log('submit!')
    },
    handleItemChange(val) {
      const lastIndex = val.length - 1
      if (lastIndex === 0) {
        this.getDistrictCount = 1
      } else if (lastIndex === 1) {
        this.getDistrictCount = 2
      } else if (lastIndex === 3) {
        return
      }
      this.lastRegionId = this.region_id // 上一次请求的region_id
      this.region_id = val[lastIndex] // 这一次请求的region_id

      if (this.getDistrictCount === 1) {
        this.district.forEach((item, index) => {
          if (item.id === this.region_id && item.children.length === 0) {
            this._getDistrict()
          }
        })
      } else if (this.getDistrictCount === 2) {
        this.district.forEach((item, index) => {
          if (item.id === this.lastRegionId && item.children.length !== 0) {
            item.children.forEach((lastItem) => {
              if (lastItem.id === this.region_id && lastItem.children.length === 0) {
                this._getDistrict()
              }
            })
          }
        })
      }
    },
    handlePositionChange(val) {
      // 通过联动select获取省市区
      const currentPosition = val
      let province, city, district
      this.district.forEach((firstItem) => {
        if (firstItem.id === currentPosition[0]) {
          console.log('first')
          province = firstItem.name
          firstItem.children.forEach((secondItem) => {
            if (secondItem.id === currentPosition[1]) {
              console.log('second')
              city = secondItem.name
              secondItem.children.forEach((thirdItem) => {
                console.log('third')
                if (thirdItem.id === currentPosition[2]) {
                  district = thirdItem.name
                }
              })
            }
          })
        }
      })
      this.proCityDist = province + city + district
      console.log('this.proCi', this.proCityDist)
    },
    handleUserInputAddress() {
      // 获取用户输入的详细地址
      this.userInputAddress = this.createShopForm.detailLocation
    },
    // 拼接用户选择的省市区和输入的详细地址
    concatAddressDetail() {
      if (this.proCityDist === '' || this.proCityDist === undefined) {
        Message({
          type: 'error',
          message: '请先选择所在地区'
        })
        return
      }
      this.detailAddress = this.proCityDist
      this.userInputAddress ? this.detailAddress += this.userInputAddress : ''
    },
    // 通过地址获取经纬度坐标
    getCoordinateByAddress() {
      this.concatAddressDetail()
      var geocoder = new AMap.Geocoder({
        radius: 1000 // 范围，默认：500
      })
      // 地理编码,返回地理编码结果
      geocoder.getLocation(this.detailAddress, function(status, result) {
        if (status === 'complete' && result.info === 'OK') {
          // 地理编码结果数组
          if (result.geocodes && result.geocodes.length > 0) {
            var geocode = result.geocodes[0]
            map.setZoomAndCenter(18, [geocode.location.lng, geocode.location.lat])
          } else {
            Message.info('找不到相关坐标，请手动查找')
          }
        }
      })
    },
    // 处理删除图片
    handleRemove(file, fileList) {
      console.log(file, fileList)
    },
    // 处理预览图片
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url
      this.dialogVisible = true
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss">
  .none-start-gutter{
    padding-left: 0 !important;
  }
  .mymap{
    width: 80%;
    height: 400px;
    border-radius: 4px;
    border: 1px solid #dcdfe6;
  }
  .shop-link{
    display: inline-block;
    line-height: 1;
    white-space: nowrap;
    cursor: pointer;
    background: #fff;
    border: 1px solid #dcdfe6;
    color: #606266;
    -webkit-appearance: none;
    text-align: center;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    outline: 0;
    margin: 0;
    -webkit-transition: .1s;
    transition: .1s;
    font-weight: 500;
    padding: 12px 20px;
    font-size: 14px;
    border-radius: 4px;
  }
</style>
