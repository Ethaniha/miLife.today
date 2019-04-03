//
//  ViewController.swift
//  MI LIFE
//
//  Created by Will Woodruff on 08/02/2019.
//  Copyright © 2019 Will Woodruff. All rights reserved.
//

import UIKit
import WebKit

class ViewController: UIViewController, WKNavigationDelegate, UITabBarDelegate {
    
    @IBOutlet weak var tabBar: UITabBar!
    @IBOutlet var webView: WKWebView!
    override func viewDidLoad() {
        super.viewDidLoad()

        loadpage(pageURLString: "http://www.milife.today/login.php")
        tabBar.selectedItem = tabBar.items![0] as UITabBarItem;
        self.tabBar.isHidden = true
        webView.addObserver(self, forKeyPath: "URL", options: .new, context: nil)
    }
    
    
    func tabBar(_ tabBar: UITabBar, didSelect item: UITabBarItem) {
        var pageURLString: NSString! = "";
        
        switch item.tag  {
            case 0:
                pageURLString = "http://www.milife.today/index.php"
                break
            case 1:
                pageURLString = "http://www.milife.today/messages.php"
                break
            case 2:
                pageURLString = "http://www.milife.today/mygroups.php"
            break
            case 3:
                pageURLString = "http://www.milife.today/user_profile.php?username="
                break
            default:
                pageURLString = "http://www.milife.today/user_settings.php"
                break
            }
        
        loadpage(pageURLString: pageURLString);
    }
    
    func loadpage(pageURLString: NSString!) {
        let pageURL = NSURL(string: pageURLString as String)
        let pageURLRequest = NSURLRequest(url: pageURL! as URL)
        webView.load(pageURLRequest as URLRequest)
    }
    
    override func observeValue(forKeyPath keyPath: String?, of object: Any?, change: [NSKeyValueChangeKey : Any]?, context: UnsafeMutableRawPointer?) {
        if let newValue = change?[.newKey] as? Int, let oldValue = change?[.oldKey] as? Int, newValue != oldValue {
            //Value Changed
            
        }else{
            let paddingConstant:CGFloat = 80.0
            
            webView.translatesAutoresizingMaskIntoConstraints = false
            webView.bottomAnchor.constraint(equalTo: self.view.bottomAnchor, constant: -paddingConstant).isActive = true
            self.tabBar.isHidden = false
        }
    }
}
