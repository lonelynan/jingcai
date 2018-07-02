<?php

namespace app\home\Controller;

use think\Controller;
use think\Db;
use think\Session;

class Json extends Controller
{

    public function index()
    {
        // print_r(json_decode('{"shebeifenlei": "\u901a\u7528", "youzhengbianma": "238000", "jishuzhibiao": "\u5206\u6790\u8303\u56f4\uff1a0.8nm-6.5\u03bcm \uff1b \u6d53\u5ea6\u8303\u56f4\uff1a\u5927\u4e8e0.1ppm\uff08200nm\u805a\u82ef\u4e59\u70ef\u4e73\u80f6\u7403\uff09\u81f3\u65e0\u4e0a\u9650\uff08\u4f9d\u636e\u6837\u54c1\u7684\u7279\u6027\u800c\u5b9a\uff09\u5149\u5b66\u7cfb\u7edf\uff1a3mW 780nm\u534a\u5bfc\u4f53\u56fa\u5b9a\u4f4d\u7f6e\u6fc0\u5149\u5668\uff0c\u901a\u8fc7\u5149\u7ea4\u76f4\u63a5\u7167\u5c04\u6837\u54c1\uff0c\u5728\u56fa\u5b9a\u4f4d\u7f6e\u7528\u7845\u4e8c\u6781\u7ba1\u63a5\u53d7\u80cc\u6563\u5c04\u5149\u4fe1\u53f7\uff0c\u65e0\u9700\u6821\u6b63\u5149\u8def\uff0c\u68c0\u6d4b\u89d2\u5ea6\uff1a180\u00b0", "pro_add": "\u4ea7\u5730\u56fd\u522b\uff1a\u7f8e\u56fd", "gongxiangguiding": "\u6309\u7167\u5b66\u6821\u76f8\u5173\u5236\u5ea6\u89c4\u5b9a\u6267\u884c\u3002", "tupian": "http://www.ahky.cn/upload/yqzy/yqtp_20171114160157911.jpg", "english_name": " \u82f1\u6587\u540d\u79f0\uff1aNanotrac Particle Size Analyzer", "qiyongriqi": "\u542f\u7528\u65e5\u671f\uff1a2008-09-01", "yuanxingzhuangtai": "\u8fd0\u884c\u72b6\u6001\uff1a\u6b63\u5e38", "yuanzhi": "\u539f\u00a0\u00a0\u00a0\u00a0\u503c\uff1a40.80\uff08\u4e07\u5143\uff09", "ruwangbianhao": "340100890002", "guigexinghao": "NPA150", "suoshudalei": "\u6240\u5c5e\u5927\u7c7b\uff1a\u5355\u53f0\u5957\u79d1\u5b66\u4eea\u5668\u8bbe\u5907", "anfangdizhi": "\u5b89\u5fbd\u7701\u5408\u80a5\u5e02\u5de2\u6e56\u5e02\u5de2\u6e56\u5b66\u9662", "suoshuleibie": "\u7c92\u5ea6\u5206\u5e03\u6d4b\u91cf\u4eea", "fuwuneirong": "\u6709\u673a\u805a\u548c\u7269\u548c\u9ad8\u5206\u5b50\u7814\u7a76\uff0c\u7eb3\u7c73\u91d1\u5c5e\u548c\u5176\u4ed6\u7eb3\u7c73\u65e0\u673a\u7269\uff0c\u7ed3\u6676\u5206\u6790\uff0c\u8868\u9762\u6d3b\u6027\u5242\u80f6\u675f\u5927\u5c0f\uff0c\u86cb\u767d\u8d28\uff0c\u753e\u4f53\uff0cDNA\uff0cRNA\uff0c\u6781\u7a00\u6d53\u5ea6\u6216\u4e0d\u5b9c\u7a00\u91ca\u9ad8\u6d53\u5ea6\u7684\u6837\u54c1\u5206\u6790\u3002", "shoufeibiaozhun": "\u9762\u8bae\u3002", "suoshudanwei": "\u6240\u5c5e\u5355\u4f4d\uff1a\u5de2\u6e56\u5b66\u9662\r\n         \r\n         \t\r\n         \r\n         \r\n         ", "tongxudizhi": "\u5de2\u6e56\u5b66\u9662\u5316\u5b66\u4e0e\u6750\u6599\u5de5\u7a0b\u5b66\u9662", "kexuelingyu": "\u6750\u6599\u79d1\u5b66,\u751f\u7269\u5b66,\u5316\u5b66", "zhizaoshang": "\u5236\u00a0\u9020\u00a0\u5546\uff1a\u7f8e\u56fd\u9ea6\u5947\u514b\u516c\u53f8", "dianxingchengguo": "\u68c0\u6d4b\u62a5\u544a\u3002", "shebeilaiyuan": "\u8d2d\u7f6e", "china_name": "\u7eb3\u7c73\u6fc0\u5149\u7c92\u5ea6\u4eea", "zhuyaogongneng": "\u65e0\u3002"}', true));
        //print_r(json_decode('{"shebeifenlei": "\u901a\u7528", "youzhengbianma": "238000", "jishuzhibiao": "\u5206\u6790\u8303\u56f4\uff1a0.8nm-6.5\u03bcm \uff1b \u6d53\u5ea6\u8303\u56f4\uff1a\u5927\u4e8e0.1ppm\uff08200nm\u805a\u82ef\u4e59\u70ef\u4e73\u80f6\u7403\uff09\u81f3\u65e0\u4e0a\u9650\uff08\u4f9d\u636e\u6837\u54c1\u7684\u7279\u6027\u800c\u5b9a\uff09\u5149\u5b66\u7cfb\u7edf\uff1a3mW 780nm\u534a\u5bfc\u4f53\u56fa\u5b9a\u4f4d\u7f6e\u6fc0\u5149\u5668\uff0c\u901a\u8fc7\u5149\u7ea4\u76f4\u63a5\u7167\u5c04\u6837\u54c1\uff0c\u5728\u56fa\u5b9a\u4f4d\u7f6e\u7528\u7845\u4e8c\u6781\u7ba1\u63a5\u53d7\u80cc\u6563\u5c04\u5149\u4fe1\u53f7\uff0c\u65e0\u9700\u6821\u6b63\u5149\u8def\uff0c\u68c0\u6d4b\u89d2\u5ea6\uff1a180\u00b0", "pro_add": "\u4ea7\u5730\u56fd\u522b\uff1a\u7f8e\u56fd", "gongxiangguiding": "\u6309\u7167\u5b66\u6821\u76f8\u5173\u5236\u5ea6\u89c4\u5b9a\u6267\u884c\u3002", "tupian": "http://www.ahky.cn/upload/yqzy/yqtp_20171114160157911.jpg", "english_name": " \u82f1\u6587\u540d\u79f0\uff1aNanotrac Particle Size Analyzer", "qiyongriqi": "\u542f\u7528\u65e5\u671f\uff1a2008-09-01", "yuanxingzhuangtai": "\u8fd0\u884c\u72b6\u6001\uff1a\u6b63\u5e38", "yuanzhi": "\u539f\u00a0\u00a0\u00a0\u00a0\u503c\uff1a40.80\uff08\u4e07\u5143\uff09", "ruwangbianhao": "340100890002", "guigexinghao": "NPA150", "suoshudalei": "\u6240\u5c5e\u5927\u7c7b\uff1a\u5355\u53f0\u5957\u79d1\u5b66\u4eea\u5668\u8bbe\u5907", "anfangdizhi": "\u5b89\u5fbd\u7701\u5408\u80a5\u5e02\u5de2\u6e56\u5e02\u5de2\u6e56\u5b66\u9662", "suoshuleibie": "\u7c92\u5ea6\u5206\u5e03\u6d4b\u91cf\u4eea", "fuwuneirong": "\u6709\u673a\u805a\u548c\u7269\u548c\u9ad8\u5206\u5b50\u7814\u7a76\uff0c\u7eb3\u7c73\u91d1\u5c5e\u548c\u5176\u4ed6\u7eb3\u7c73\u65e0\u673a\u7269\uff0c\u7ed3\u6676\u5206\u6790\uff0c\u8868\u9762\u6d3b\u6027\u5242\u80f6\u675f\u5927\u5c0f\uff0c\u86cb\u767d\u8d28\uff0c\u753e\u4f53\uff0cDNA\uff0cRNA\uff0c\u6781\u7a00\u6d53\u5ea6\u6216\u4e0d\u5b9c\u7a00\u91ca\u9ad8\u6d53\u5ea6\u7684\u6837\u54c1\u5206\u6790\u3002", "shoufeibiaozhun": "\u9762\u8bae\u3002", "suoshudanwei": "\u6240\u5c5e\u5355\u4f4d\uff1a\u5de2\u6e56\u5b66\u9662\r\n         \r\n         \t\r\n         \r\n         \r\n         ", "tongxudizhi": "\u5de2\u6e56\u5b66\u9662\u5316\u5b66\u4e0e\u6750\u6599\u5de5\u7a0b\u5b66\u9662", "kexuelingyu": "\u6750\u6599\u79d1\u5b66,\u751f\u7269\u5b66,\u5316\u5b66", "zhizaoshang": "\u5236\u00a0\u9020\u00a0\u5546\uff1a\u7f8e\u56fd\u9ea6\u5947\u514b\u516c\u53f8", "dianxingchengguo": "\u68c0\u6d4b\u62a5\u544a\u3002", "shebeilaiyuan": "\u8d2d\u7f6e", "china_name": "\u7eb3\u7c73\u6fc0\u5149\u7c92\u5ea6\u4eea", "zhuyaogongneng": "\u65e0\u3002"}'));
         print_r(json_decode('{"machine_name": "圆二色光谱仪(CD)(纳米区域中心)", "region_owner": "北京物质和纳米科学大型仪器区域中心", "appoinment_format": "丁丽萍,光谱-1,刘美蓉", "machine_big": "室内分析测试设备", "machine_mid": "光谱仪器", "manufacture_country": "日本", "machine_notes": "", "machine_type": "J-815", "examine_people": "丁丽萍,光谱-1,刘美蓉", "manufacture_name": "日本 JASCO", "machine_main_func_desc": "", "machine_small": "圆二色光谱仪器", "machine_id": "1154", "unit_owner": "所属区域中心", "machine_image": "http://samp.cas.cn/sams/jqFileUploadAction.do?method=getFullFile&fileId=2147003089", "machine_state": "正常", "machine_buy_time": "2007/01/15", "appoinment_type": "必须预约", "use_people": "光谱-1,徐媛,ic光谱-2,刘美蓉,丁丽萍", "price_info": [{"analysis_standard": "用户指定", "demo_class_id": "1", "service_price": "400", "pre_standard": "用户指定", "project_analysis": "圆二色光谱常温测试", "demo_class": "液态"}, {"analysis_standard": "用户指定", "demo_class_id": "2", "service_price": "600", "pre_standard": "用户指定", "project_analysis": "圆二色光谱仪附件DRCD测试", "demo_class": "固态"}, {"analysis_standard": "用户指定", "demo_class_id": "3", "service_price": "600", "pre_standard": "用户指定", "project_analysis": "LD光谱测试", "demo_class": "固态或液态"}, {"analysis_standard": "用户指定", "demo_class_id": "4", "service_price": "600", "pre_standard": "用户指定", "project_analysis": "圆二色光谱变温测试（变温CD）", "demo_class": "液态"}], "machine_placed": "5-0129", "type": "DataItem"}',true));
        //        print_r(json_decode('{"function": "\u9002\u7528\u4e8e\u7eb3\u7cb9\u6750\u6599\u7cbe\u7ec6\u5f62\u8c8c\u7684\u89c2\u5bdf\uff0c\u53ef\u859b\u5229\u9ad8\u8d28\u91cf\u9ad8\u5206\u8fa8\u4e8c\u6b21\u7535\u5b50\u56fe\u50cf\u3002\u8be5\u4eea\u5668\u914d\u5907\u7684X\u5c04\u7ebf\u80fd\u8c31\u4eea\u53ef\u5bf9\u5757\u72b6\u6837\u54c1\u505a\u5b9a\u6027\u53ca\u534a\u5b9a\u91cf\u5206\u6790\u3002\u53ef\u5411\u6837\u54c1\u5ba4\u5145\u5165\u591a\u79cd\u6c14\u4f53\uff0c\u5728\u4f4e\u771f\u7a7a\u4e0b\u4ecd\u80fd\u83b7\u5f97\u4f18\u4e8e2nm\u7684\u9ad8\u5206\u8fa8\u56fe\u50cf\uff1b\u53ef\u5411\u6837\u54c1\u5ba4\u901a\u5165\u6c34\u84b8\u6c14\uff0c\u4f7f\u542b\u6c34\u3001\u542b\u6cb9\u53ca\u4e0d\u5bfc\u6837\u54c1\u53ef\u76f4\u63a5\u89c2\u5bdf\uff1b\u53ef\u5728\u6837\u54c1\u5ba4\u5185\u5bf9\u6837\u54c1\u505a\u52a0\u6e29\uff08\u53ef\u8fbe1000\u2103\uff09\u3001\u4f4e\u6e29\uff08\u8fbe\uff0d20\u2103\uff09\u5904\u7406\uff0c\u5bf9\u5316\u5b66\u53cd\u5e94\u8fc7\u7a0b\u8fdb\u884c\u5b9e\u65f6\u89c2\u6d4b\u3002\u8be5\u8bbe\u5907\u9002\u7528\u4e8e\u7269\u7406\u3001\u6750\u6599\u3001\u534a\u5bfc\u4f53\u3001\u8d85\u5bfc\u4f53\u3001\u5316\u5b66\u9ad8\u5206\u5b50\u3001\u5730\u8d28\u77ff\u7269\u3001\u751f\u7269\u3001\u533b\u5b66\u7b49\u9886\u57df\u7684\u5fae\u89c2\u7814\u7a76\u548c\u5206\u6790\u3002", "fax": "", "external_service_instruction": "", "use_pattern": "\u5bf9\u5916\u5f00\u653e", "remark": "", "company": "\u5317\u4eac\u5927\u5b66", "province_city": "\u5317\u4eac\u5e02", "manufacturer_country": "", "instrument_alias": "", "telephone": "62751427", "sample": "", "unit_set": "", "purpose": "", "english_name": "", "charge_person": "\u9648\u8389", "laboratory": "", "construction_organization": "", "applicable_industry": "\u5730\u8d28\u52d8\u67e5\n\uff0c\n\u79d1\u5b66\u7814\u7a76\n\uff0c\n\u533b\u836f/\u536b\u751f\n\uff0c\n\u7164\u70ad/\u77f3\u6cb9/\u77f3\u5316\n\uff0c\n\u94a2\u94c1/\u6709\u8272\u91d1\u5c5e\n\uff0c\n\u975e\u91d1\u5c5e/\u73e0\u5b9d\n\uff0c\n\u6a61\u80f6/\u5851\u6599\n\uff0c\n\u519c/\u6797/\u7267/\u6e14", "technical_index": "\u4e8c\u6b21\u7535\u5b50\u6210\u50cf\uff0c\u80cc\u6563\u5c04\u6210\u50cf\uff0c\u9634\u6781\u8367\u5149\u6210\u50cf\uff1b  \u5206\u8fa8\u7387\uff1a\u9ad8\u771f\u7a7a\uff1a30KV\u65f6\uff0c\u4e3a1.5nm\uff1b  1KV\u65f6\uff0c\u4e3a3nm\uff1b X\u5c04\u7ebf\u80fd\u8c31\u5206\u6790\uff1a\u80fd\u91cf\u5206\u8fa8150eV\uff1b\u5143\u7d20\u5206\u6790\u8303\u56f4B\uff0dU\uff1b \u9ad8\u6027\u80fd\u9634\u6781\u8367\u5149\uff1a\u5177\u6709\u5bf9\u7279\u5b9a\u6ce2\u957f\u5149\u8c31\u5206\u6790\u4e0e\u6210\u50cf\uff08\u6307\u5b9a\u6ce2\u957f\u5149\u8c31\u9762\u5206\u5e03\uff09\u7684\u80fd\u529b\uff0c\u6ce2\u957f\u5206\u8fa8\u7387\u4f18\u4e8e30nm\uff0c\u6d4b\u8bd5\u7684\u6ce2\u957f\u5206\u8fa8\u7387\u4f18\u4e8e30nm\uff0c\u6d4b\u8bd5\u7684\u6ce2\u957f\u8303\u56f4\u662f200nm\uff0d900nm\u3002", "manufacturer": "FEI\u516c\u53f8", "new_developed_function": "", "product_model": "Quanta 200F", "position": "\u5317\u4eac\u5927\u5b66\u7269\u7406\u5b66\u9662\u7535\u955c\u5ba4", "production_date": "", "running_status": "\u6b63\u5e38", "chinese_name": "\u573a\u53d1\u5c04\u73af\u5883\u626b\u63cf\u7535\u955c", "pass_metering_authentication": "\u5426", "test_item": "", "fees": "\u57fa\u672c\u6536\u8d39:400\u5143/\u5c0f\u65f6", "commissioning_date": "2004-07-01", "email": "chenli@pku.edu.cn", "update_time": "2007-08-16", "upgrading_date": "", "purchase_date": "", "metrology_inspection_date": "", "retirement_date": "", "service_class": "\u63d0\u4f9b\u6570\u636e", "grundlagen": "", "instrument_classification": "\u5206\u6790\u4eea\u5668", "laboratory_approved": "\u5426", "instrument_purchase_funding_source": "\u4e2d\u592e\u8d22\u653f\u62e8\u6b3e", "verification": ""}',true));
//        print_r(json_decode('{"function": "\u9002\u7528\u4e8e\u7eb3\u7cb9\u6750\u6599\u7cbe\u7ec6\u5f62\u8c8c\u7684\u89c2\u5bdf\uff0c\u53ef\u859b\u5229\u9ad8\u8d28\u91cf\u9ad8\u5206\u8fa8\u4e8c\u6b21\u7535\u5b50\u56fe\u50cf\u3002\u8be5\u4eea\u5668\u914d\u5907\u7684X\u5c04\u7ebf\u80fd\u8c31\u4eea\u53ef\u5bf9\u5757\u72b6\u6837\u54c1\u505a\u5b9a\u6027\u53ca\u534a\u5b9a\u91cf\u5206\u6790\u3002\u53ef\u5411\u6837\u54c1\u5ba4\u5145\u5165\u591a\u79cd\u6c14\u4f53\uff0c\u5728\u4f4e\u771f\u7a7a\u4e0b\u4ecd\u80fd\u83b7\u5f97\u4f18\u4e8e2nm\u7684\u9ad8\u5206\u8fa8\u56fe\u50cf\uff1b\u53ef\u5411\u6837\u54c1\u5ba4\u901a\u5165\u6c34\u84b8\u6c14\uff0c\u4f7f\u542b\u6c34\u3001\u542b\u6cb9\u53ca\u4e0d\u5bfc\u6837\u54c1\u53ef\u76f4\u63a5\u89c2\u5bdf\uff1b\u53ef\u5728\u6837\u54c1\u5ba4\u5185\u5bf9\u6837\u54c1\u505a\u52a0\u6e29\uff08\u53ef\u8fbe1000\u2103\uff09\u3001\u4f4e\u6e29\uff08\u8fbe\uff0d20\u2103\uff09\u5904\u7406\uff0c\u5bf9\u5316\u5b66\u53cd\u5e94\u8fc7\u7a0b\u8fdb\u884c\u5b9e\u65f6\u89c2\u6d4b\u3002\u8be5\u8bbe\u5907\u9002\u7528\u4e8e\u7269\u7406\u3001\u6750\u6599\u3001\u534a\u5bfc\u4f53\u3001\u8d85\u5bfc\u4f53\u3001\u5316\u5b66\u9ad8\u5206\u5b50\u3001\u5730\u8d28\u77ff\u7269\u3001\u751f\u7269\u3001\u533b\u5b66\u7b49\u9886\u57df\u7684\u5fae\u89c2\u7814\u7a76\u548c\u5206\u6790\u3002", "fax": "", "external_service_instruction": "", "use_pattern": "\u5bf9\u5916\u5f00\u653e", "remark": "", "company": "\u5317\u4eac\u5927\u5b66", "province_city": "\u5317\u4eac\u5e02", "manufacturer_country": "", "instrument_alias": "", "telephone": "62751427", "sample": "", "unit_set": "", "purpose": "", "english_name": "", "charge_person": "\u9648\u8389", "laboratory": "", "construction_organization": "", "applicable_industry": "\u5730\u8d28\u52d8\u67e5\n\uff0c\n\u79d1\u5b66\u7814\u7a76\n\uff0c\n\u533b\u836f/\u536b\u751f\n\uff0c\n\u7164\u70ad/\u77f3\u6cb9/\u77f3\u5316\n\uff0c\n\u94a2\u94c1/\u6709\u8272\u91d1\u5c5e\n\uff0c\n\u975e\u91d1\u5c5e/\u73e0\u5b9d\n\uff0c\n\u6a61\u80f6/\u5851\u6599\n\uff0c\n\u519c/\u6797/\u7267/\u6e14", "technical_index": "\u4e8c\u6b21\u7535\u5b50\u6210\u50cf\uff0c\u80cc\u6563\u5c04\u6210\u50cf\uff0c\u9634\u6781\u8367\u5149\u6210\u50cf\uff1b  \u5206\u8fa8\u7387\uff1a\u9ad8\u771f\u7a7a\uff1a30KV\u65f6\uff0c\u4e3a1.5nm\uff1b  1KV\u65f6\uff0c\u4e3a3nm\uff1b X\u5c04\u7ebf\u80fd\u8c31\u5206\u6790\uff1a\u80fd\u91cf\u5206\u8fa8150eV\uff1b\u5143\u7d20\u5206\u6790\u8303\u56f4B\uff0dU\uff1b \u9ad8\u6027\u80fd\u9634\u6781\u8367\u5149\uff1a\u5177\u6709\u5bf9\u7279\u5b9a\u6ce2\u957f\u5149\u8c31\u5206\u6790\u4e0e\u6210\u50cf\uff08\u6307\u5b9a\u6ce2\u957f\u5149\u8c31\u9762\u5206\u5e03\uff09\u7684\u80fd\u529b\uff0c\u6ce2\u957f\u5206\u8fa8\u7387\u4f18\u4e8e30nm\uff0c\u6d4b\u8bd5\u7684\u6ce2\u957f\u5206\u8fa8\u7387\u4f18\u4e8e30nm\uff0c\u6d4b\u8bd5\u7684\u6ce2\u957f\u8303\u56f4\u662f200nm\uff0d900nm\u3002", "manufacturer": "FEI\u516c\u53f8", "new_developed_function": "", "product_model": "Quanta 200F", "position": "\u5317\u4eac\u5927\u5b66\u7269\u7406\u5b66\u9662\u7535\u955c\u5ba4", "production_date": "", "running_status": "\u6b63\u5e38", "chinese_name": "\u573a\u53d1\u5c04\u73af\u5883\u626b\u63cf\u7535\u955c", "pass_metering_authentication": "\u5426", "test_item": "", "fees": "\u57fa\u672c\u6536\u8d39:400\u5143/\u5c0f\u65f6", "commissioning_date": "2004-07-01", "email": "chenli@pku.edu.cn", "update_time": "2007-08-16", "upgrading_date": "", "purchase_date": "", "metrology_inspection_date": "", "retirement_date": "", "service_class": "\u63d0\u4f9b\u6570\u636e", "grundlagen": "", "instrument_classification": "-\u7535\u5b50\u5149\u5b66\u4eea\u5668", "laboratory_approved": "\u5426", "instrument_purchase_funding_source": "\u4e2d\u592e\u8d22\u653f\u62e8\u6b3e", "verification": ""}',true));
//        print_r(json_decode('{"function": "\u9002\u7528\u4e8e\u7eb3\u7cb9\u6750\u6599\u7cbe\u7ec6\u5f62\u8c8c\u7684\u89c2\u5bdf\uff0c\u53ef\u859b\u5229\u9ad8\u8d28\u91cf\u9ad8\u5206\u8fa8\u4e8c\u6b21\u7535\u5b50\u56fe\u50cf\u3002\u8be5\u4eea\u5668\u914d\u5907\u7684X\u5c04\u7ebf\u80fd\u8c31\u4eea\u53ef\u5bf9\u5757\u72b6\u6837\u54c1\u505a\u5b9a\u6027\u53ca\u534a\u5b9a\u91cf\u5206\u6790\u3002\u53ef\u5411\u6837\u54c1\u5ba4\u5145\u5165\u591a\u79cd\u6c14\u4f53\uff0c\u5728\u4f4e\u771f\u7a7a\u4e0b\u4ecd\u80fd\u83b7\u5f97\u4f18\u4e8e2nm\u7684\u9ad8\u5206\u8fa8\u56fe\u50cf\uff1b\u53ef\u5411\u6837\u54c1\u5ba4\u901a\u5165\u6c34\u84b8\u6c14\uff0c\u4f7f\u542b\u6c34\u3001\u542b\u6cb9\u53ca\u4e0d\u5bfc\u6837\u54c1\u53ef\u76f4\u63a5\u89c2\u5bdf\uff1b\u53ef\u5728\u6837\u54c1\u5ba4\u5185\u5bf9\u6837\u54c1\u505a\u52a0\u6e29\uff08\u53ef\u8fbe1000\u2103\uff09\u3001\u4f4e\u6e29\uff08\u8fbe\uff0d20\u2103\uff09\u5904\u7406\uff0c\u5bf9\u5316\u5b66\u53cd\u5e94\u8fc7\u7a0b\u8fdb\u884c\u5b9e\u65f6\u89c2\u6d4b\u3002\u8be5\u8bbe\u5907\u9002\u7528\u4e8e\u7269\u7406\u3001\u6750\u6599\u3001\u534a\u5bfc\u4f53\u3001\u8d85\u5bfc\u4f53\u3001\u5316\u5b66\u9ad8\u5206\u5b50\u3001\u5730\u8d28\u77ff\u7269\u3001\u751f\u7269\u3001\u533b\u5b66\u7b49\u9886\u57df\u7684\u5fae\u89c2\u7814\u7a76\u548c\u5206\u6790\u3002", "fax": "", "external_service_instruction": "", "use_pattern": "\u5bf9\u5916\u5f00\u653e", "remark": "", "company": "\u5317\u4eac\u5927\u5b66", "province_city": "\u5317\u4eac\u5e02", "manufacturer_country": "", "instrument_alias": "", "telephone": "62751427", "sample": "", "unit_set": "", "purpose": "", "english_name": "", "charge_person": "\u9648\u8389", "laboratory": "", "construction_organization": "", "applicable_industry": "\u5730\u8d28\u52d8\u67e5\n\uff0c\n\u79d1\u5b66\u7814\u7a76\n\uff0c\n\u533b\u836f/\u536b\u751f\n\uff0c\n\u7164\u70ad/\u77f3\u6cb9/\u77f3\u5316\n\uff0c\n\u94a2\u94c1/\u6709\u8272\u91d1\u5c5e\n\uff0c\n\u975e\u91d1\u5c5e/\u73e0\u5b9d\n\uff0c\n\u6a61\u80f6/\u5851\u6599\n\uff0c\n\u519c/\u6797/\u7267/\u6e14", "technical_index": "\u4e8c\u6b21\u7535\u5b50\u6210\u50cf\uff0c\u80cc\u6563\u5c04\u6210\u50cf\uff0c\u9634\u6781\u8367\u5149\u6210\u50cf\uff1b  \u5206\u8fa8\u7387\uff1a\u9ad8\u771f\u7a7a\uff1a30KV\u65f6\uff0c\u4e3a1.5nm\uff1b  1KV\u65f6\uff0c\u4e3a3nm\uff1b X\u5c04\u7ebf\u80fd\u8c31\u5206\u6790\uff1a\u80fd\u91cf\u5206\u8fa8150eV\uff1b\u5143\u7d20\u5206\u6790\u8303\u56f4B\uff0dU\uff1b \u9ad8\u6027\u80fd\u9634\u6781\u8367\u5149\uff1a\u5177\u6709\u5bf9\u7279\u5b9a\u6ce2\u957f\u5149\u8c31\u5206\u6790\u4e0e\u6210\u50cf\uff08\u6307\u5b9a\u6ce2\u957f\u5149\u8c31\u9762\u5206\u5e03\uff09\u7684\u80fd\u529b\uff0c\u6ce2\u957f\u5206\u8fa8\u7387\u4f18\u4e8e30nm\uff0c\u6d4b\u8bd5\u7684\u6ce2\u957f\u5206\u8fa8\u7387\u4f18\u4e8e30nm\uff0c\u6d4b\u8bd5\u7684\u6ce2\u957f\u8303\u56f4\u662f200nm\uff0d900nm\u3002", "manufacturer": "FEI\u516c\u53f8", "new_developed_function": "", "product_model": "Quanta 200F", "position": "\u5317\u4eac\u5927\u5b66\u7269\u7406\u5b66\u9662\u7535\u955c\u5ba4", "production_date": "", "running_status": "\u6b63\u5e38", "chinese_name": "\u573a\u53d1\u5c04\u73af\u5883\u626b\u63cf\u7535\u955c", "pass_metering_authentication": "\u5426", "test_item": "", "fees": "\u57fa\u672c\u6536\u8d39:400\u5143/\u5c0f\u65f6", "commissioning_date": "2004-07-01", "email": "chenli@pku.edu.cn", "update_time": "2007-08-16", "upgrading_date": "", "purchase_date": "", "metrology_inspection_date": "", "retirement_date": "", "service_class": "\u63d0\u4f9b\u6570\u636e", "grundlagen": "", "instrument_classification": "\u626b\u63cf\u7535\u955c", "laboratory_approved": "\u5426", "instrument_purchase_funding_source": "\u4e2d\u592e\u8d22\u653f\u62e8\u6b3e", "verification": ""}',true));
    }
//江苏1
public function jiangsu1()
{
    $file = fopen("d:/parse_suzhou.json", "r");

    $user = array();
    $i = 0;
    while (!feof($file)) {
        $user = fgets($file);
        //$user=substr($user,0,strlen($user)-1);

        $arr = json_decode($user, true);
        // print_r($arr);
        $chinese_name = $arr['machine_name'];
        $english_name = "";
        $product_model = $arr['machine_type'];

        $manufacturer_country = "";
        $purchase_date = $arr['machine_buy_date'];
        $company = $arr['compony'];
        $running_status = "";
        $charge_person = $arr['machine_response'];
        $telephone = "";
        $manufacturer = $arr['machine_cus'];
        $email = "";
        $function = $arr['machine_use'];
        $img_url = "";
        $qiyongriqi = $arr['machine_use_date'];
        $service_content = $arr['machine_service_region'];
        $yuanxingzhuangtai = "";
        $ruwangbianhao = "";
        $jishuzhibiao = $arr['tech_stan'];
        $suoshudalei = "";
        $anfangdizhi = "";
        $suoshuleibie = $arr['machine_class'];
        $tongxudizhi = "";
        $kexuelingyu = "";
        $remark = "";
        $sample = "";
        $test_item = "";
        $fees = $arr['service_price'];
        {
            $data = ['equipment_category_id' => $suoshuleibie, 'unit_name' => $company, 'detail' => $function, 'ch_name' => $chinese_name,
                'remark' => $remark, 'sample' => $sample, 'test_item' => $test_item, 'service_fees' => $fees,
                'en_name' => $english_name, 'commissioning_date' => $qiyongriqi, 'running_status' => $yuanxingzhuangtai, 'service_content' => $service_content
                , 'instr_properties2' => $ruwangbianhao, 'technical_index' => $jishuzhibiao, 'suoshudalei' => $suoshudalei, 'position' => $anfangdizhi
                , 'suoshuleibie' => $suoshuleibie, 'address' => $tongxudizhi, 'kexuelingyu' => $kexuelingyu, 'province_city' => 3, 'running_status' => $running_status
                , 'img_url' => $img_url, 'service_fees' => $fees, 'service_person' => $charge_person, 'service_telephone' => $telephone, 'service_email' => $email
                , 'instr_manufacturer' => $manufacturer, 'instr_manufacturer_country' => $manufacturer_country, 'instr_purchase_date' => $purchase_date,
                'instr_specification_model' => $product_model];
            Db::table('mat_equipment')->insert($data);
        }
    }
}
    //江苏
    public function jiangsu()
    {
        $file = fopen("d:/jiangsu1.json", "r");

        $user = array();
        $i = 0;
        while (!feof($file)) {
            $user = fgets($file);
            //$user=substr($user,0,strlen($user)-1);

            $arr = json_decode($user, true);
            // print_r($arr);
            $chinese_name = $arr['machine_name'];
            $english_name = "";
            $product_model = $arr['machine_type'];

            $manufacturer_country = $arr['manufacture_country'];
            $purchase_date = $arr['machine_buy_time'];
            $company = $arr['unit_owner'];
            $running_status = $arr['machine_state'];
            $charge_person = "";
            $telephone = "";
            $manufacturer = $arr['manufacture_name'];
            $email = "";
            $function = $arr['machine_main_func_desc'];
            $img_url = $arr['machine_image'];
            $qiyongriqi = "";
            $service_content = "";
            $yuanxingzhuangtai = "";
            $ruwangbianhao = "";
            $jishuzhibiao = "";
            $suoshudalei = $arr['machine_big'];
            $anfangdizhi = $arr['machine_placed'];
            $suoshuleibie = $arr['machine_mid'];
            $tongxudizhi = "";
            $kexuelingyu = "";
            $remark = $arr['machine_notes'];
            $sample= "";
            $test_item= "";
            $fees = json_encode($arr['price_info']);
//  `machine_small` varchar(255) DEFAULT NULL COMMENT '其他计算和数据分析设备 ',


            $data = ['equipment_category_id' => $suoshuleibie, 'unit_name' => $company, 'detail' => $function, 'ch_name' => $chinese_name,
                'remark'=>$remark,'sample'=>$sample, 'test_item' => $test_item,'service_fees' => $fees,
                'en_name' => $english_name, 'commissioning_date' => $qiyongriqi, 'running_status' => $yuanxingzhuangtai, 'service_content' => $service_content
                , 'instr_properties2' => $ruwangbianhao, 'technical_index' => $jishuzhibiao, 'suoshudalei' => $suoshudalei, 'position' => $anfangdizhi
                , 'suoshuleibie' => $suoshuleibie, 'address' => $tongxudizhi, 'kexuelingyu' => $kexuelingyu, 'province_city' => 0,'running_status'=>$running_status
                , 'img_url' => $img_url, 'service_fees' => $fees, 'service_person' => $charge_person, 'service_telephone' => $telephone, 'service_email' => $email
                , 'instr_manufacturer' => $manufacturer, 'instr_manufacturer_country' => $manufacturer_country, 'instr_purchase_date' => $purchase_date,
                'instr_specification_model' => $product_model];
            Db::table('mat_equipment_jiangsu')->insert($data);
        }
    }

    //北京
    public function beijing()
    {
        $file = fopen("d:/afterparse_kytj.json", "r");
        $user = array();
        $i = 0;
        while (!feof($file)) {
            $user = fgets($file);
            $arr = json_decode($user, true);
            $chinese_name = $arr['chinese_name'];
            $english_name = $arr['english_name'];
            $product_model = $arr['product_model'];
            $instrument_alias = $arr['instrument_alias'];
            $instrument_classification = $arr['instrument_classification'];
            $manufacturer_country = $arr['manufacturer_country'];
            $purchase_date = $arr['purchase_date'];
            $production_date = $arr['production_date'];
            $retirement_date = $arr['retirement_date'];
            $company = $arr['company'];
            $charge_person = $arr['charge_person'];
            $telephone = $arr['telephone'];
            $manufacturer = $arr['manufacturer'];
            $email = $arr['email'];
            $function = $arr['function'];
            $fees = $arr['fees'];
            $grundlagen = $arr['grundlagen'];
            $laboratory = $arr['laboratory'];
            $applicable_industry = $arr['applicable_industry'];
            $technical_index = $arr['technical_index'];
            $test_item = $arr['test_item'];
            $running_status = $arr['running_status'];
            $remark = $arr['remark'];
            $sample = $arr['sample'];
            $external_service_instruction = $arr['external_service_instruction'];

            $data = ['equipment_category_id' => $instrument_classification, 'unit_name' => $company, 'detail' => $function, 'ch_name' => $chinese_name
                , 'en_name' => $english_name, 'instr_alias' => $instrument_alias, 'instr_production_date' => $production_date
                , 'instr_retirement_date' => $retirement_date, 'grundlagen' => $grundlagen, 'laboratory' => $laboratory,'sample'=>$sample
                , 'applicable_industry' => $applicable_industry, 'technical_index' => $technical_index, 'province_city' => 1
                , 'test_item' => $test_item, 'running_status' => $running_status, 'remark' => $remark, 'service_content' => $external_service_instruction
                , 'img_url' => '', 'service_fees' => $fees, 'service_person' => $charge_person, 'service_telephone' => $telephone, 'service_email' => $email
                , 'instr_manufacturer' => $manufacturer, 'instr_manufacturer_country' => $manufacturer_country, 'instr_purchase_date' => $purchase_date,
                'instr_specification_model' => $product_model];
            Db::table('mat_equipment')->insert($data);
            /* chinese_name, 中文名称
 product_model, 规格型号
 instrument_alias, 仪器别名
 instrument_classification, 仪器分类
 manufacturer, 生产厂商
 manufacturer_country, 厂商国别
 production_date, 生产日期
 purchase_date, 购进日期
 retirement_date, 报废日期
 grundlagen, 购进方式
 instrument_purchase_funding_source, 购置经费来源
 verification, 检定情况
 company, 所在单位
 charge_person, 负责人
 telephone, 联系电话
 email， 邮箱
 function， 功能用途
 fees， 收费标准*/
        }
        fclose($file);
    }
    //上海
    //安徽
    public function anhui()
    {
        $file = fopen("d:/anhui.json", "r");

        $user = array();
        $i = 0;
        while (!feof($file)) {
            $user = fgets($file);
            //$user=substr($user,0,strlen($user)-1);

            $arr = json_decode($user, true);
            // print_r($arr);
            $chinese_name = $arr['china_name'];
            $english_name = $arr['english_name'];
            $product_model = $arr['guigexinghao'];

            $instrument_classification = $arr['shebeifenlei'];
            $manufacturer_country = $arr['pro_add'];
            $purchase_date = "";

            $company = $arr['suoshudanwei'];
            $charge_person = "";
            $telephone = "";
            $manufacturer = $arr['zhizaoshang'];
            $email = "";
            $function = "";
            $fees = $arr['shoufeibiaozhun'];
            $img_url = $arr['tupian'];
            $qiyongriqi = $arr['qiyongriqi'];
            $service_content = $arr['fuwuneirong'];
            $yuanxingzhuangtai = $arr['yuanxingzhuangtai'];
            $ruwangbianhao = $arr['ruwangbianhao'];
            $jishuzhibiao = $arr['jishuzhibiao'];
            $suoshudalei = $arr['suoshudalei'];
            $anfangdizhi = $arr['anfangdizhi'];
            $suoshuleibie = $arr['suoshuleibie'];
            $tongxudizhi = $arr['tongxudizhi'];
            $kexuelingyu = $arr['kexuelingyu'];

            $data = ['equipment_category_id' => $suoshuleibie, 'unit_name' => $company, 'detail' => $function, 'ch_name' => $chinese_name,
                'en_name' => $english_name, 'commissioning_date' => $qiyongriqi, 'running_status' => $yuanxingzhuangtai, 'service_content' => $service_content
                , 'instr_properties2' => $ruwangbianhao, 'technical_index' => $jishuzhibiao, 'suoshudalei' => $suoshudalei, 'position' => $anfangdizhi
                , 'suoshuleibie' => $suoshuleibie, 'address' => $tongxudizhi, 'kexuelingyu' => $kexuelingyu, 'province_city' => 4
                , 'img_url' => $img_url, 'service_fees' => $fees, 'service_person' => $charge_person, 'service_telephone' => $telephone, 'service_email' => $email
                , 'instr_manufacturer' => $manufacturer, 'instr_manufacturer_country' => $manufacturer_country, 'instr_purchase_date' => $purchase_date,
                'instr_specification_model' => $product_model];
            Db::table('mat_equipment')->insert($data);
        }
    }
    public function update(){
          $query=DB::query("select  * from mat_equipment_category ");
          foreach ($query as $v){
              $id=$v['id'];
              $name=$v['equipment_category_name'];
              Db::table('mat_equipment')->where('equipment_category_id', $name)->update(['equipment_category_id' => $id]);
          }
    }
}
