<template>
  <div class="app-container">

    <el-button type='primary' size='mini' @click='ruleAdd'>添加权限</el-button>

    <tree-table @editTable="editTable" @deleteTable="deleteTable" :data="data" :columns="columns" border v-loading.body='listLoading'></tree-table>

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
        <el-form-item label='状态'>
          <el-cascader
            :options="alterRules"
            change-on-select
            v-model='form.parent_id'
          ></el-cascader>
        </el-form-item>

      </el-form>
      <div slot='footer' class='dialog-footer'>
        <el-button @click='dialogFormVisible = false'>取 消</el-button>
        <el-button type='primary' @click='formSubmit'>确 定</el-button>
      </div>
    </el-dialog>


  </div>
</template>

<script>
/**
  Auth: Lei.j1ang
  Created: 2018/1/19-14:54
*/
import treeTable from '@/components/TreeTable'
import { getRuleList, ruleDetail, ruleEdit, ruleAdd, ruleDeleteOne } from '@/api/rule'

export default {
  name: 'ruleListTable',
  components: { treeTable },
  created() {
    this.getRuleList()
  },
  data() {
    return {
      columns: [
        {
          text: '权限名称',
          value: 'label',
          width: 300
        },
        {
          text: '模块/控制器/方法',
          value: 'name'
        },
        {
          text: '附加条件',
          value: 'timeLine'
        },
        {
          text: '状态',
          value: 'status_value'
        },
        {
          text: '操作',
          value: 'operation'
        }
      ],
      data: [],
      alterRules: [],
      dialogFormVisible: false,
      form: {
        id: '',
        name: '',
        title: '',
        condition: '',
        status: 0,
        parent_id: []
      },
      formLabelWidth: '120px'
    }
  },
  methods: {
    getRuleList() {
      this.listLoading = true
      this.data = []
      getRuleList().then(response => {
        this.data = response.data
        this.listLoading = false
      })
    },
    formSubmit: function() {
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
    editTable: function(id) {
      this.dialogFormVisible = true
      this.form.id = id
      ruleDetail(id).then(response => {
        const data = response.data
        this.form.name = data.name
        this.form.title = data.title
        this.form.condition = data.condition
        this.form.status = data.status
        this.form.parent_id = data.parent_id
        this.alterRules = data.rules
      })
    },
    deleteTable: function(id) {
      ruleDeleteOne(id).then(response => {
        this.getRuleList()
      })
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
    }
  }
}
</script>
