import React from "react";
import {Button} from "react-bootstrap";
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
import RetV2 from "components/RetV2";
import PageHeader from "components/PageHeader";

export default class extends React.Component {
  state = {
    columns: [],
  };

  componentDidMount() {
    let columns = [
      {
        text: 'PV',
        dataField: 'viewCount',
        sort: true,
      },
      {
        text: 'UV',
        dataField: 'viewUser',
        sort: true,
      },
      {
        text: '关注数',
        dataField: 'subscribeUser',
        sort: true,
      },
      {
        text: '取关数',
        dataField: 'unsubscribeUser',
        sort: true,
      },
      {
        text: '净增关注数',
        dataField: 'netSubscribeValue',
        sort: true,
      },
      {
        text: '有消费会员数',
        dataField: 'consumeMemberUser',
        sort: true,
      },
      {
        text: '领取会员卡数',
        dataField: 'receiveMemberCount',
        sort: true,
      },
      {
        text: '领取优惠券数',
        dataField: 'receiveCardCount',
        sort: true,
      },
      {
        text: '核销优惠券数',
        dataField: 'consumeCardCount',
        sort: true,
      },
      {
        text: '增加积分数',
        dataField: 'addScoreValue',
        sort: true,
      },
      {
        text: '使用积分数',
        dataField: 'subScoreValue',
        sort: true,
      },
      {
        text: '订单数',
        dataField: 'orderCount',
        sort: true,
      },
      {
        text: '订单金额',
        dataField: 'orderAmountValue',
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
      ret.columns = columns.filter(column => {
        return ret.columns.includes(column.dataField);
      });
      this.setState(ret);
    });
  }

  render() {
    const stat = this.state.statType ? (this.state.statType + '-') : '';

    return <RetV2 ret={this.state}>
      <PageHeader>
        <Button href={app.curNewUrl()} bsStyle="success">添加</Button>
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
              },
            ].concat(this.state.columns)
              .concat([
                {
                  text: '创建时间',
                  dataField: 'createdAt',
                },
                {
                  text: '操作',
                  headerClasses: 't-11',
                  formatter: (cell, {id}) => <Actions>
                    <a href={app.url('admin/source-' + stat + 'stats/show', {source_id: id})}>统计</a>
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
    </RetV2>;
  }
}
