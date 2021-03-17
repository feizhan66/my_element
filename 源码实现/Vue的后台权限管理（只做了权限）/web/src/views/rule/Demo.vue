<template>
<div class='custom-tree-container'>
  <div class='block'>
    <p>使用 render-content</p>
    <el-tree
      :data='data4'
      show-checkbox
      node-key='id'
      default-expand-all
      :expand-on-click-node='false'
      :render-content='renderContent'>
    </el-tree>


    <el-dialog title='收货地址' :visible.sync='dialogFormVisible'>
      <el-form :model='form'>
        <el-form-item label='活动名称' :label-width='formLabelWidth'>
          <el-input v-model='form.name' auto-complete='off'></el-input>
        </el-form-item>
        <el-form-item label='活动区域' :label-width='formLabelWidth'>
          <el-select v-model='form.region' placeholder='请选择活动区域'>
            <el-option label='区域一' value='shanghai'></el-option>
            <el-option label='区域二' value='beijing'></el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot='footer' class='dialog-footer'>
        <el-button @click='dialogFormVisible = false'>取 消</el-button>
        <el-button type='primary' @click='dialogFormVisible = false'>确 定</el-button>
      </div>
    </el-dialog>
  </div>

</div>
</template>

<script>
  let id = 1000

  export default {
    data() {
      const data = [{
        id: 1,
        label: '一级 1',
        children: [{
          id: 4,
          label: '二级 1-1',
          children: [{
            id: 9,
            label: '三级 1-1-1'
          }, {
            id: 10,
            label: '三级 1-1-2'
          }]
        }]
      }, {
        id: 2,
        label: '一级 2',
        children: [{
          id: 5,
          label: '二级 2-1'
        }, {
          id: 6,
          label: '二级 2-2'
        }]
      }, {
        id: 3,
        label: '一级 3',
        children: [{
          id: 7,
          label: '二级 3-1'
        }, {
          id: 8,
          label: '二级 3-2'
        }]
      }]
      return {
        data4: JSON.parse(JSON.stringify(data)),
        dialogFormVisible: false,
        form: {
          name: '',
          region: '',
          date1: '',
          date2: '',
          delivery: false,
          type: [],
          resource: '',
          desc: ''
        },
        formLabelWidth: '120px'
      }
    },

    methods: {
      edit(data) {
        this.dialogFormVisible = true
        console.log(data)
      },
      append(data) {
        const newChild = { id: id++, label: 'testtest', children: [] }
        if (!data.children) {
          this.$set(data, 'children', [])
        }
        data.children.push(newChild)
      },

      remove(node, data) {
        const parent = node.parent
        const children = parent.data.children || parent.data
        const index = children.findIndex(d => d.id === data.id)
        children.splice(index, 1)
      },

      renderContent(h, { node, data, store }) {
        return (
          <span class='custom-tree-node'>
            <span>{node.label}</span>
            <span>
              <el-button size='mini' type='text' on-click={ () => this.edit(data) }>编辑</el-button>
              <el-button size='mini' type='text' on-click={ () => this.append(data) }>添加</el-button>
              <el-button size='mini' type='text' on-click={ () => this.remove(node, data) }>删除</el-button>
            </span>
          </span>
        )
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
