import React from "react";
import {Button, PageHeader} from "react-bootstrap";
import CNewBtn from "components/CNewBtn";
import TableProvider from "components/TableProvider";
import SearchForm from "components/SearchForm";
import SearchItem from "components/SearchItem";
import Options from "components/Options";
import SearchDateRangePicker from "components/SearchDateRangePicker";
import Table from "components/Table";
import app from "app";
import Actions from "components/Actions";
import CDeleteLink from "components/CDeleteLink";

export default class extends React.Component {
  state = {
    columns: [],
  };

  componentDidMount() {
    let columns = [
      {
        text: 'PV',
        dataField: 'view_count',
        sort: true,
      },
      {
        text: 'UV',
        dataField: 'view_user',
        sort: true,
      },
      {
        text: '关注数',
        dataField: 'subscribe_user',
        sort: true,
      },
      {
        text: '取关数',
        dataField: 'unsubscribe_user',
        sort: true,
      },
      {
        text: '净增关注数',
        dataField: 'net_subscribe_value',
        sort: true,
      },
      {
        text: '有消费会员数',
        dataField: 'consume_member_user',
        sort: true,
      },
      {
        text: '领取会员卡数',
        dataField: 'receive_member_count',
        sort: true,
      },
      {
        text: '领取优惠券数',
        dataField: 'receive_card_count',
        sort: true,
      },
      {
        text: '核销优惠券数',
        dataField: 'consume_card_count',
        sort: true,
      },
      {
        text: '增加积分数',
        dataField: 'add_score_value',
        sort: true,
      },
      {
        text: '使用积分数',
        dataField: 'sub_score_value',
        sort: true,
      },
      {
        text: '订单数',
        dataField: 'order_count',
        sort: true,
      },
      {
        text: '订单金额',
        dataField: 'order_amount_count',
        sort: true,
      },
      {
        text: '订单金额',
        data: 'id',
        render: function (data, type, full) {
          return template.render('js-qrcode-scene-id-tpl', full);
        }
      },
    ];

    app.get(app.actionUrl('metadata')).then(ret => {
      columns = columns.filter(column => {
        return ret.columns.includes(column.dataField);
      });
      this.setState({columns: columns});
    });
  }

  render() {
    return <>
      <PageHeader>
        <div className="pull-right">
          <Button href={app.curNewUrl()} bsStyle="success">添加</Button>
        </div>
        {wei.page.controllerTitle}
      </PageHeader>

      <TableProvider>
        {({reload}) => <>
          <SearchForm>
            <SearchItem label="名称" name="name$ct"/>
            <SearchDateRangePicker label="创建时间" name="createdAt" min="$ge" max="$le"/>
          </SearchForm>

          <Table
            columns={[
              {
                text: '标识',
                dataField: 'code',
              },
              {
                text: '名称',
                dataField: 'name'
              }
            ].concat(this.state.columns)
              .concat([
                {
                  text: '创建时间',
                  dataField: 'createdAt'
                },
                {
                  text: '操作',
                  headerClasses: 't-11',
                  formatter: (cell, {id}) => <Actions>
                    <a href={app.url('admin/source-weekly-stats/show', {source_id: id})}>统计</a>
                    <a href={app.url('admin/sources/%s/generate-link', id)}>生成链接</a>
                    <a href={app.curEditUrl(id)}>编辑</a>
                    <CDeleteLink id={id}/>
                  </Actions>
                }
              ])
            }
          />
        </>}
      </TableProvider>
    </>;
  }
}
