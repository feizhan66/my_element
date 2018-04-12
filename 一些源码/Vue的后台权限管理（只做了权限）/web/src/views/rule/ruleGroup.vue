<template>
  <div class="app-container">
    <div>
      <el-button type='success' @click='alertRuleLoad()'>添加权限组</el-button>
    </div>
    <div>
      <el-table :data="list" v-loading.body="listLoading" element-loading-text="Loading" border fit highlight-current-row>
        <el-table-column align="center" label='索引' width="50">
          <template slot-scope="scope">
            {{scope.$index}}
          </template>
        </el-table-column>
        <el-table-column align="center" label='ID' width="95">
          <template slot-scope="scope">
            {{scope.row.id}}
          </template>
        </el-table-column>
        <el-table-column label="标题" align="center">
          <template slot-scope="scope">
            {{scope.row.title}}
          </template>
        </el-table-column>
        <el-table-column label="描述"  align="center">
          <template slot-scope="scope">
            <span>{{scope.row.description}}</span>
          </template>
        </el-table-column>
        <el-table-column class-name="status-col" label="状态" width="110" align="center">
          <template slot-scope="scope">
            <el-tag :type="scope.row.status | statusFilter">{{scope.row.status}}</el-tag>
          </template>
        </el-table-column>
        <el-table-column align="center" prop="created_at" label="操作" width="200">
          <template slot-scope="scope">
            <el-button type='primary' @click='alertRuleLoad(scope.row.id)'>修改</el-button>
            <el-button type='danger' @click='deleteRules(scope.row.id)'>删除</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>

    <el-dialog title="修改权限组信息" :visible.sync="dialogFormVisible" v-loading.body="formLoading" element-loading-text="Loading">
      <el-form :model="form">
        <el-form-item label="标题" :label-width="formLabelWidth">
          <el-input v-model="form.title" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label='状态'>
          <el-radio-group v-model='form.status'>
            <el-radio v-model="form.status" :label='0'>关闭</el-radio>
            <el-radio v-model="form.status" :label='1'>开启</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="描述" :label-width="formLabelWidth">
          <el-input v-model="form.description" auto-complete="off"></el-input>
        </el-form-item>

      </el-form>

      <el-tree
        :data="ruleList"
        show-checkbox
        default-expand-all
        node-key="id"
        ref="tree"
        highlight-current
        :props="defaultProps">
      </el-tree>

      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="alertRuleSubmit">确 定</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
  import { roleList, roleDetail, roleUpdate, roleDelete, roleAdd } from '@/api/rule'

  export default {
    data() {
      return {
        list: null,
        listLoading: true,
        dialogFormVisible: false,
        formLoading: false,
        form: {
          role_id: '',
          name: '',
          title: '',
          description: '',
          status: 0
        },
        formLabelWidth: '120px',
        ruleList: [],
        defaultProps: {
          children: 'children',
          label: 'label'
        }
      }
    },
    filters: {
      statusFilter(status) {
        const statusMap = {
          published: 'success',
          draft: 'gray',
          deleted: 'danger'
        }
        return statusMap[status]
      }
    },
    created() {
      this.fetchData()
    },
    methods: {
      // 获取权限组的列表
      fetchData() {
        this.listLoading = true
        roleList(this.listQuery).then(response => {
          this.list = response.data.items
          this.listLoading = false
        })
      },
      alertRuleLoad(role_id) {
        this.dialogFormVisible = true
        // 加载数据
        this.form = []
        this.formLoading = true
        roleDetail(role_id).then(response => {
          this.ruleList = response.data.rules
          this.form = response.data.role
          this.$refs.tree.setCheckedKeys(response.data.has_rules)
          this.formLoading = false
        })
      },
      alertRuleSubmit() {
        // 获取选中的项
        const rules = this.$refs.tree.getCheckedKeys()
        // 如果ID存在的话就更新，不存在就新增
        if (this.form.role_id > 0) {
          //
          // 获取表单的值
          roleUpdate(this.form, rules).then(response => {
            console.log('更新')
            this.dialogFormVisible = false
            this.fetchData()
          })
        } else {
          roleAdd(this.form, rules).then(response => {
            console.log('添加')
            this.dialogFormVisible = false
            this.fetchData()
          })
        }
      },
      deleteRules(rules) {
        roleDelete(rules).then(response => {
          this.fetchData()
        })
      }
    }
  }
</script>
