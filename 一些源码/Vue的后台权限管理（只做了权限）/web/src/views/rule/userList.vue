<template>
  <div class="app-container">
    <el-table :data="list" v-loading.body="listLoading" element-loading-text="Loading" border fit highlight-current-row>
      <el-table-column align="center" label='用户ID' width="95">
        <template slot-scope="scope">
          {{scope.row.user_id}}
        </template>
      </el-table-column>
      <el-table-column label="用户名" align="center">
        <template slot-scope="scope">
          {{scope.row.user_name}}
        </template>
      </el-table-column>
      <el-table-column label="手机号" width="110" align="center">
        <template slot-scope="scope">
          <span>{{scope.row.mobile_phone}}</span>
        </template>
      </el-table-column>
      <el-table-column label="拥有权限" align="center">
        <template slot-scope="scope">
          {{scope.row.roles}}
        </template>
      </el-table-column>
      <el-table-column class-name="status-col" label="状态" width="110" align="center">
        <template slot-scope="scope">
          <el-tag :type="scope.row.status | statusFilter">{{scope.row.status}}</el-tag>
        </template>
      </el-table-column>
      <el-table-column align="center" prop="created_at" label="操作" width="200">
        <template slot-scope="scope">
          <el-button @click="alertRoleLoading(scope.row.user_id)">编辑</el-button>
        </template>
      </el-table-column>
    </el-table>

    <div class="block" align="center">
      <el-pagination
        layout="prev, pager, next"
        @current-change="changePage"
        :current-page="page"
        :total="count">
      </el-pagination>
    </div>

    <el-dialog title="修改权限组信息" :visible.sync="dialogFormVisible" v-loading.body="formLoading" element-loading-text="Loading">

      <el-transfer
        v-model="value1"
        :data="data"
      ></el-transfer>

      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="alertRoleSubmit">确 定</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
  import { userList, userRoleList, alertUserRole } from '@/api/rule'

  export default {
    data() {
      return {
        data: [],
        value1: [],
        list: null,
        people_id: '',
        count: 0,
        page: 1,
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
        formLabelWidth: '120px'
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
      fetchData() {
        this.listLoading = true
        userList(this.page).then(response => {
          this.list = response.data.items
          for (let i = 0; i < this.list.length; i++) {
            if (this.list[i].status === 0) {
              this.list[i].status = '无效'
            } else {
              this.list[i].status = '有效'
            }
          }
          this.count = response.data.count
          this.listLoading = false
        })
      },
      changePage(val) {
        userList(val).then(response => {
          this.list = response.data.items
          this.count = response.data.count
          this.listLoading = false
        })
      },
      alertRoleLoading(people_id) {
        this.dialogFormVisible = true
        this.data = []
        this.people_id = people_id
        userRoleList(people_id).then(response => {
          const roleList = response.data.roleList
          for (let i = 0; i < roleList.length; i++) {
            this.data.push({
              key: roleList[i].id,
              label: roleList[i].title
            })
          }
          this.value1 = response.data.peopleRoles
          this.listLoading = false
        })
      },
      alertRoleSubmit() {
        alertUserRole(this.people_id, this.value1).then(response => {
          this.dialogFormVisible = false
          this.listLoading = false
          this.fetchData()
        })
      }
    }
  }
</script>
