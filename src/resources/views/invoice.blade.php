<!DOCTYPE html>
<html>
<head>
<style>
@page { margin: 50px 40px 40px 40px; }
table, td, th {
    border: 1px solid black;
    padding: 5px;
  }
td{
    padding-left:20px;
}
.table_style{
    border-collapse: collapse;
    margin-top:20px;
width:100%;
border: 1px solid black;
}
p {
    padding : 0px;
    margin : 0px;
}
.exeption p{
    padding : 0px;
    margin : 20px;
}
.sizetext p{
    font-size:13px;
}

.lisp , .lisp td, .lisp tr{
    margin-top:-10px;
    padding:0px; 
    border: 0px solid black;
  }
  .lisp th{
    margin-top:0px;
    border: 0px solid black;
    
  }

  .lisp2 , .lisp2 td, .lisp2 tr{
    border: 0px solid black;
    text-align: right
  }
  .lisp2 th{
    border: 0px solid black;
    text-align: right
    
  }
  .style1{
      color:#95989d;
  }
  .style2{
      color:#212f5b;
      font-size:22px;
      font-weight:50;
      font-family: Roboto, Tahoma, sans-serif;
  }
.style3{
    color:#2d3a63;
    font-weight:50;
    font-family: Roboto, Tahoma, sans-serif;
}
.separator{
margin-top:70px;
}
thead{
    display: table-header-group;
    vertical-align: middle;
    border-color: inherit;
    background-color:#d2d5de;
}
hr{
    border: 1px dashed #d2d5de;
    margin-top:20px;
}
.infor p{
    color:#95989d;
    
}
.infor{
    margin-top:-20px;
}
.middles{
    color:#95989d;
    font-size: 22px;
    text-align:center;
    margin-top:-20px;
}
.rightes{
    text-align:right;
    font-size: 22px;
    font-weight:bold;
}
</style>
</head>
<body>
<img
align="right"
    width="220"
    height="170"
src="{{ $admin->logo }}"
    alt="logo.jpg"
/>
 <h3><b>{{ $admin->name }}</b></h3>
 <p>{{ $admin->location }}</p>
 <p>{{ $admin->phone }}</p>
 <p>Fax {{ $admin->fax }}</p>
 <p>{{ $admin->email }}
 </p>

 <div class="separator">

<h3 class="style2">INVOICE</h3>
<table class="lisp" style="width:100%">
<tr> 
 <td class="style1">BILL TO </td>
 <td style="color:white">sssssssssssssssssssssssssssssss</td>
 <td class="style1">INVOICE </td>
 <td>{{ $admin->invoicenumber }} </td>
</tr>
<tr> 
 <td>{{ $load->broker->name }}</td>
 <td> </td>
 <td class="style1">DATE</td>
 <td>{{ date('m/d/Y', strtotime($load->invoiced_at)) }} </td>
</tr>
<tr> 
 <td>{{ $load->broker->address }}</td>
 <td> </td>
 <td class="style1"> TERMS</td>
 @if ($load->term==0)
    <td style="color:green;font-weight:bold">Quick Pay</td> 
 @else
 <td>Net {{ $load->term }} </td>
 @endif
 
</tr>
<tr> 
 <td>p.{{ $load->broker->phone }} f.{{ $load->broker->fax }}</td>
 <td> </td>
 <td class="style1"> DUE DATE</td>
 
     @if ($load->term==0)
    <td style="color:green;font-weight:bold">Quick Pay</td> 
 @else
 <td>{{date('m/d/Y', strtotime($load->deadline)) }} </td>
 @endif

</tr>
<tr> 
    <td> {{ $load->broker->email }}</td>
    <td> </td>
    <td ></td>
    <td></td>
   </tr>
</table>
</div>

<table class="lisp2" style="width:100%l;margin-top:40px">
<thead>
<tr >
<th  class="style3">DATE </th>
<th  class="style3">DESCRIPTION </th>
<th  class="style3">QTY </th>
<th  class="style3">RATE </th>
<th  class="style3">AMOUNT </th>
</tr>
</thead>
<tr>
<td>{{  date('m/d/Y', strtotime($load->pickup()->time)) }}  </td>
<td>{{ $load->pickup()->location->city }} {{ $load->pickup()->location->state }} - {{ $load->delivery()->location->city }} {{ $load->delivery()->location->state }} </td>
<td> 1</td>
<td> {{ $load->price }}</td>
<td> {{ $load->price }}</td>
</tr>
</table>
<hr>

<p class="rightes">${{ $load->price }}
</p>

<p class="middles">BALANCE DUE
</p>


<div class="infor">

<p>{{ $admin->bank }}</p>
 <p>Accounting #{{ $admin->accounting }} </p>
 <p>Routing #{{ $admin->routing }} </p>
 </div>
</body>
</html>