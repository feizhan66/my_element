<template>
  <div class='app-container' v-loading.body='listLoading'>

    <el-row>
      <el-col :span="20" :offset="2">
        <div class="grid-content bg-purple-dark">
          <div class='block'>
            <el-button type='primary' size='mini' @click='ruleAdd'>添加权限</el-button>
            <el-tree
              :data='data2'
              default-expand-all
              node-key='id'
              ref='tree'
              highlight-current
              :expand-on-click-node='false'
              :render-content='renderContent'
              :props='defaultProps'>

            </el-tree>
          </div>
        </div>
      </el-col>
    </el-row>

    <el-dialog title='编辑权限' :visible.sync='dialogFormVisible'>
      <el-form :model='form'>

        <el-form-item label='权限名称' :label-width='formLabelWidth'>
          <el-input v-model='form.title' auto-complete='off'></el-input>
        </el-form-item>
        <el-form-item label='模块/控制器/方法' :label-width='formLabelWidth'>
          <el-input v-model='form.name' auto-complete='off'></el-input>
        </el-form-item>
        <el-form-item label='附加条件' :label-width='formLabelWidth'>
          <el-input v-model='form.condition' auto-complete='off'></el-input>
        </el-form-item>

        <el-form-item label='状态'>
          <el-radio-group v-model='form.status'>
            <el-radio v-model='form.status' :label='0'>关闭</el-radio>
            <el-radio v-model='form.status' :label='1'>开启</el-radio>
          </el-radio-group>
        </el-form-item>
        <!--<el-form-item label='父级' :label-width='formLabelWidth'>-->
          <!--<el-input v-model='form.parent_id' auto-complete='off'></el-input>-->
        <!--</el-form-item>-->

        <el-cascader
          :options="alterRules"
          change-on-select
          v-model='form.parent_id'
        ></el-cascader>

      </el-form>
      <div slot='footer' class='dialog-footer'>
        <el-button @click='dialogFormVisible = false'>取 消</el-button>
        <el-button type='primary' @click='formSubmit'>确 定</el-button>
      </div>
    </el-dialog>
  </div>

</template>

<script>
  import { getRuleList, ruleDetail, ruleEdit, ruleAdd, ruleDeleteOne } from '@/api/rule'

  export default {
    created() {
      this.getRuleList()
    },
    watch: {
      filterText(val) {
        this.$refs.tree2.filter(val)
      }
    },
    methods: {
      getRuleList() {
        this.listLoading = true
        this.data2 = []
        getRuleList().then(response => {
          this.data2 = response.data
          this.listLoading = false
          console.log(response)
        })
      },
      filterNode(value, data) {
        if (!value) return true
        return data.label.indexOf(value) !== -1
      },
      // 编辑-添加完成
      formSubmit() {
        const id = this.form.id
        if (id === '') {
          // 添加
          ruleAdd(this.form).then(response => {
            if (response.code === 200) {
              this.$message({
                message: '恭喜你，添加权限成功',
                type: 'success'
              })
              this.dialogFormVisible = false
              this.getRuleList()
            } else {
              this.$message.error('错了哦，这是一条错误消息')
            }
          })
        } else {
          // 修改
          ruleEdit(this.form).then(response => {
            if (response.code === 200) {
              this.$message({
                message: '恭喜你，修改成功',
                type: 'success'
              })
              this.dialogFormVisible = false
              this.getRuleList()
            } else {
              this.$message.error('错了哦,这是一条错误消息')
            }
          })
        }
      },
      ruleAdd() {
        this.dialogFormVisible = true
        this.form.id = ''
        this.form.name = ''
        this.form.title = ''
        this.form.condition = ''
        this.form.status = 0
        this.form.parent_id = [0]
        ruleDetail().then(response => {
          const data = response.data
          this.alterRules = data.rules
        })
      },
      // 开始编辑
      edit(data) {
        this.dialogFormVisible = true
        this.form.id = data.id
        // 请求接口
        ruleDetail(this.form.id).then(response => {
          const data = response.data
          this.form.name = data.name
          this.form.title = data.title
          this.form.condition = data.condition
          this.form.status = data.status
          this.form.parent_id = data.parent_id
          this.alterRules = data.rules
        })
      },

      remove(node, data) {
        // 执行删除操作
        ruleDeleteOne(data.id).then(response => {
          const parent = node.parent
          const children = parent.data.children || parent.data
          const index = children.findIndex(d => d.id === data.id)
          children.splice(index, 1)
        })
      },
      renderContent(h, { node, data, store }) {
        return (
          <span class='custom-tree-node'>
            <span>{node.label}</span>
            <span>
              <el-button size='mini' type='text' on-click={ () => this.edit(data) }>编辑</el-button>
              <el-button size='mini' type='text' on-click={ () => this.remove(node, data) }>删除</el-button>
            </span>
          </span>
        )
      }
    },

    data() {
      return {
        listLoading: true,
        data2: [],
        alterRules: [],
        defaultProps: {
          children: 'children',
          label: 'label'
        },
        dialogFormVisible: false,
        form: {
          id: '',
          name: '',
          title: '',
          condition: '',
          status: 0,
          parent_id: ''
        },
        formLabelWidth: '120px',
        options: [{
          value: 'xinyun',
          label: 'zzzz',
          children: [{
            value: 'xinyun',
            label: 'zzzz'
          }]
        }]
      }
    }
  }
</script>
<style>
  .custom-tree-node {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    padding-right: 8px;
  }
</style>
